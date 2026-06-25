<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * Comando Artisan para generar módulos CRUD completos de Livewire.
 *
 * Este comando automatiza la creación de todas las clases y vistas necesarias
 * para un módulo CRUD de Livewire, incluyendo: Index, Table, Create, Edit, Show
 * con sus respectivos Form Objects y vistas Blade.
 *
 * Uso: php artisan app:crud {module_name}
 * Ejemplo: php artisan app:crud Specialty
 */
class LivewireCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crud {module_name : The module path and name (e.g., Admin/User or Product)}
                            {--form-namespace= : Custom namespace for form objects (default: same as module)}
                            {--without-forms : Skip form object generation}
                            {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a complete Livewire CRUD Module with classes, forms, and views';

    /**
     * Nombre del módulo normalizado en StudlyCase (e.g., User).
     */
    protected string $module_name;

    /**
     * Namespace del módulo (e.g., Admin\User or Product).
     */
    protected string $module_namespace;

    /**
     * Path relativo del módulo para vistas (e.g., admin/user or product).
     */
    protected string $module_view_path;

    /**
     * Namespace para los Form Objects (e.g., Admin o CustomModule\Users).
     */
    protected string $form_namespace;

    /**
     * Indica si se deben generar los Form Objects.
     */
    protected bool $with_forms = true;

    /**
     * Instancia del sistema de archivos.
     */
    protected Filesystem $file;

    /**
     * Contador de archivos creados exitosamente.
     */
    protected int $filesCreated = 0;

    /**
     * Contador de archivos omitidos (ya existen).
     */
    protected int $filesSkipped = 0;

    /**
     * Lista de errores encontrados durante la generación.
     *
     * @var array<string>
     */
    protected array $errors = [];

    /**
     * Stubs requeridos para la generación del CRUD.
     *
     * @var array<string>
     */
    protected array $requiredStubs = [
        'livewire.crud.index.stub',
        'livewire.crud.table.stub',
        'livewire.crud.create.stub',
        'livewire.crud.create.form.stub',
        'livewire.crud.edit.stub',
        'livewire.crud.edit.form.stub',
        'livewire.crud.show.stub',
        'livewire.crud.index.view.stub',
        'livewire.crud.table.view.stub',
        'livewire.crud.create.view.stub',
        'livewire.crud.edit.view.stub',
        'livewire.crud.show.view.stub',
    ];

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * Flujo principal de ejecución:
     * 1. Valida y recopila parámetros
     * 2. Verifica que existan los stubs necesarios
     * 3. Genera las clases Livewire y Form Objects
     * 4. Genera las vistas Blade
     * 5. Muestra un resumen de la operación
     *
     * @return int Exit code (0 = success, 1 = error)
     */
    public function handle(): int
    {
        // Muestra banner informativo
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('  Livewire CRUD Generator');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();

        // 1. Valida y recopila todos los parámetros necesarios
        if (!$this->gatherParameters()) {
            return 1;
        }

        // 2. Verifica que existan todos los stubs requeridos
        if (!$this->validateStubsExist()) {
            return 1;
        }

        // 3. Genera las clases Livewire y Form Objects
        $this->info('Generating Livewire classes...');
        $this->generateLivewireCrudClassFile();

        // 4. Genera las vistas Blade
        $this->info('Generating Blade views...');
        $this->generateLivewireCrudViewFile();

        // 5. Muestra resumen final
        $this->displaySummary();

        return empty($this->errors) ? 0 : 1;
    }

    /**
     * Gather and validate all necessary parameters.
     *
     * Valida que:
     * - El nombre del módulo esté presente
     * - El path sea válido (permite namespaces con /)
     * - Normaliza el nombre y namespace
     * - Configura los namespaces de forms según opciones
     *
     * @return bool True si los parámetros son válidos, false en caso contrario
     */
    protected function gatherParameters(): bool
    {
        // Obtiene el nombre del módulo del argumento
        $modulePath = $this->argument('module_name');

        // Valida que el nombre no esté vacío
        if (empty($modulePath)) {
            $this->error('❌ Module path is required.');
            $this->comment('Usage: php artisan app:crud {module_path}');
            $this->comment('Examples:');
            $this->comment('  php artisan app:crud User');
            $this->comment('  php artisan app:crud Admin/User');
            $this->comment('  php artisan app:crud Modules/Products/Product');

            return false;
        }

        // Valida que el path sea válido (permite letras, números, /, guiones y guiones bajos)
        if (!preg_match('/^[a-zA-Z0-9\/_-]+$/', $modulePath)) {
            $this->error('❌ Module path must contain only letters, numbers, forward slashes, hyphens, and underscores.');
            $this->comment("Invalid path: {$modulePath}");

            return false;
        }

        // Normaliza el path separando namespace y nombre del módulo
        $parts = explode('/', $modulePath);
        $this->module_name = Str::studly(array_pop($parts)); // Último elemento es el nombre

        // Si hay partes antes del nombre, son el namespace
        if (!empty($parts)) {
            $this->module_namespace = implode('\\', array_map([Str::class, 'studly'], $parts));
            $this->module_view_path = Str::lower(implode('/', array_map([Str::class, 'kebab'], $parts)));
        } else {
            // Si no hay namespace, por defecto no tiene
            $this->module_namespace = '';
            $this->module_view_path = '';
        }

        // Determina si se generarán forms
        $this->with_forms = !$this->option('without-forms');

        // Configura el namespace de los forms
        if ($this->with_forms) {
            if ($customFormNamespace = $this->option('form-namespace')) {
                // Namespace personalizado para forms
                $this->form_namespace = str_replace('/', '\\', $customFormNamespace);
            } else {
                // Por defecto, mismo namespace que el módulo
                $this->form_namespace = $this->module_namespace;
            }
        }

        // Muestra la configuración
        $this->info("✓ Module name: {$this->module_name}");
        if (!empty($this->module_namespace)) {
            $this->info("✓ Module namespace: {$this->module_namespace}");
        }
        if ($this->with_forms) {
            $this->info("✓ Form namespace: {$this->form_namespace}");
        } else {
            $this->warn('⊘ Forms will NOT be generated (--without-forms)');
        }
        $this->newLine();

        return true;
    }

    /**
     * Validate that all required stub files exist.
     *
     * Verifica la existencia de todos los archivos stub necesarios antes
     * de intentar generar los archivos. Esto previene errores parciales.
     *
     * @return bool True si todos los stubs existen, false si falta alguno
     */
    protected function validateStubsExist(): bool
    {
        $missingStubs = [];

        // Verifica cada stub requerido
        foreach ($this->requiredStubs as $stub) {
            $stubPath = base_path("stubs/{$stub}");
            if (!$this->file->exists($stubPath)) {
                $missingStubs[] = $stub;
            }
        }

        // Si faltan stubs, muestra error detallado
        if (!empty($missingStubs)) {
            $this->error('❌ Missing required stub files:');
            foreach ($missingStubs as $stub) {
                $this->line("   - stubs/{$stub}");
            }
            $this->newLine();
            $this->comment('Please ensure all stub files exist in the stubs/ directory.');

            return false;
        }

        return true;
    }

    /**
     * Generate all CRUD Livewire class files.
     *
     * Genera los siguientes archivos PHP:
     * - {Module}Index.php: Componente de listado principal
     * - {Module}Table.php: Componente de tabla con búsqueda y paginación
     * - {Module}Create.php: Componente de creación
     * - {Module}CreateForm.php: Form Object para validación de creación (opcional)
     * - {Module}Edit.php: Componente de edición
     * - {Module}EditForm.php: Form Object para validación de edición (opcional)
     * - {Module}Show.php: Componente de visualización
     *
     * Cada archivo se genera a partir de su stub correspondiente,
     * reemplazando los placeholders con las variantes del nombre del módulo.
     */
    protected function generateLivewireCrudClassFile(): void
    {
        // Genera cada componente individual
        $this->generateIndexClass();
        $this->generateTableClass();
        $this->generateCreateClass();

        if ($this->with_forms) {
            $this->generateCreateFormClass();
        }

        $this->generateEditClass();

        if ($this->with_forms) {
            $this->generateEditFormClass();
        }

        $this->generateShowClass();
    }

    /**
     * Generate the Index Livewire component.
     *
     * Crea la clase principal del módulo que sirve como contenedor
     * para los demás componentes (tabla, formularios, etc.).
     */
    protected function generateIndexClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.index.stub');

        // Construye el path del archivo de forma dinámica
        $relativePath = $this->module_namespace
            ? str_replace('\\', '/', $this->module_namespace) . '/' . $this->module_name
            : $this->module_name;
        $destination = app_path("Livewire/{$relativePath}/{$this->module_name}Index.php");

        // Verifica si el archivo ya existe
        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        // Lee el contenido del stub
        $content = $this->file->get($stubPath);

        // Construye el namespace completo para la clase
        $fullNamespace = $this->module_namespace
            ? $this->module_namespace . '\\' . $this->module_name
            : $this->module_name;

        // Construye el path de la vista usando puntos (notación de Laravel)
        $viewPath = $this->module_view_path
            ? str_replace('/', '.', $this->module_view_path) . '.' . Str::kebab($this->module_name)
            : Str::kebab($this->module_name);

        // Reemplaza los placeholders
        $replacedContent = Str::replaceArray('{{}}', [
            $fullNamespace,                        // Namespace: Admin\User
            $this->module_name,                    // Class: UserIndex
            Str::lower($this->module_name),        // module_name: 'user'
            Str::plural(Str::lower($this->module_name)),       // module_name_plural: 'Users'
            $viewPath,                             // view path: admin.user
            Str::kebab($this->module_name),        // view file: user
        ], $content);

        // Crea el archivo
        $this->createFile($destination, $replacedContent, 'Index class');
    }

    /**
     * Generate the Table Livewire component.
     *
     * Crea el componente de tabla que maneja la paginación, búsqueda,
     * filtrado y eliminación de registros.
     */
    protected function generateTableClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.table.stub');

        // Construye el path del archivo de forma dinámica
        $relativePath = $this->module_namespace
            ? str_replace('\\', '/', $this->module_namespace) . '/' . $this->module_name
            : $this->module_name;
        $destination = app_path("Livewire/{$relativePath}/{$this->module_name}Table.php");

        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        $content = $this->file->get($stubPath);

        // Construye el namespace completo
        $fullNamespace = $this->module_namespace
            ? $this->module_namespace . '\\' . $this->module_name
            : $this->module_name;

        // Construye el path de la vista usando puntos (notación de Laravel)
        $viewPath = $this->module_view_path
            ? str_replace('/', '.', $this->module_view_path) . '.' . Str::kebab($this->module_name)
            : Str::kebab($this->module_name);

        // Reemplazos: namespace, class, model (3x), variable (3x), view (2x)
        $replacedContent = Str::replaceArray('{{}}', [
            $fullNamespace,                        // Namespace
            $this->module_name,                    // Class
            $this->module_name,                    // Use Model
            Str::lower($this->module_name),        // $variable en método delete
            $this->module_name,                    // Model::find()
            Str::lower($this->module_name),        // $variable->delete()
            $this->module_name,                    // Model para query
            $viewPath,                             // view path: admin.user
            Str::kebab($this->module_name),        // view file: user
        ], $content);

        $this->createFile($destination, $replacedContent, 'Table class');
    }

    /**
     * Generate the Create Livewire component.
     *
     * Crea el componente que maneja la lógica de creación de nuevos registros,
     * integrándose con el CreateForm object.
     */
    protected function generateCreateClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.create.stub');

        // Construye el path del archivo de forma dinámica
        $relativePath = $this->module_namespace
            ? str_replace('\\', '/', $this->module_namespace) . '/' . $this->module_name
            : $this->module_name;
        $destination = app_path("Livewire/{$relativePath}/{$this->module_name}Create.php");

        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        $content = $this->file->get($stubPath);

        // Construye los namespaces
        $fullNamespace = $this->module_namespace
            ? $this->module_namespace . '\\' . $this->module_name
            : $this->module_name;

        // Construye el namespace completo para el Form (incluyendo el nombre de la clase)
        $formNamespaceForUse = $this->with_forms
            ? ($this->form_namespace ? $this->form_namespace . '\\' . $this->module_name : $fullNamespace)
            : '';

        // Construye el path de la vista usando puntos (notación de Laravel)
        $viewPath = $this->module_view_path
            ? str_replace('/', '.', $this->module_view_path) . '.' . Str::kebab($this->module_name)
            : Str::kebab($this->module_name);

        $replacedContent = Str::replaceArray('{{}}', [
            $fullNamespace,                        // Namespace
            $formNamespaceForUse,                  // Use Form namespace
            $this->module_name,                    // Class
            Str::lower($this->module_name),        // module_name property
            Str::plural(Str::lower($this->module_name)), // module_name_plural property
            $this->module_name,                    // Form type hint
            $this->module_name,                    // Redirect Index class
            $viewPath,                             // view path: admin.user
            Str::kebab($this->module_name),        // view file: user
        ], $content);

        $this->createFile($destination, $replacedContent, 'Create class');
    }

    /**
     * Generate the CreateForm object.
     *
     * Crea el Form Object que encapsula la validación y lógica
     * de persistencia para la creación de registros.
     */
    protected function generateCreateFormClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.create.form.stub');

        // Construye el path del archivo de forma dinámica
        $formPath = $this->form_namespace
            ? str_replace('\\', '/', $this->form_namespace)
            : ($this->module_namespace ? str_replace('\\', '/', $this->module_namespace) : '');

        $destination = app_path("Livewire/Forms/{$formPath}/{$this->module_name}CreateForm.php");

        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        $content = $this->file->get($stubPath);

        $replacedContent = Str::replaceArray('{{}}', [
            $this->form_namespace ?: ($this->module_namespace ?: ''), // Namespace for form
            $this->module_name,                    // Use Model
            $this->module_name,                    // Class name
            $this->module_name,                    // Model::create()
        ], $content);

        $this->createFile($destination, $replacedContent, 'CreateForm class');
    }

    /**
     * Generate the Edit Livewire component.
     *
     * Crea el componente que maneja la edición de registros existentes,
     * cargando el modelo y actualizándolo mediante el EditForm object.
     */
    protected function generateEditClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.edit.stub');

        // Construye el path del archivo de forma dinámica
        $relativePath = $this->module_namespace
            ? str_replace('\\', '/', $this->module_namespace) . '/' . $this->module_name
            : $this->module_name;
        $destination = app_path("Livewire/{$relativePath}/{$this->module_name}Edit.php");

        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        $content = $this->file->get($stubPath);

        // Construye los namespaces
        $fullNamespace = $this->module_namespace
            ? $this->module_namespace . '\\' . $this->module_name
            : $this->module_name;

        // Construye el namespace completo para el Form (incluyendo el nombre de la clase)
        $formNamespaceForUse = $this->with_forms
            ? ($this->form_namespace ? $this->form_namespace . '\\' . $this->module_name : $fullNamespace)
            : '';

        // Construye el path de la vista usando puntos (notación de Laravel)
        $viewPath = $this->module_view_path
            ? str_replace('/', '.', $this->module_view_path) . '.' . Str::kebab($this->module_name)
            : Str::kebab($this->module_name);

        $replacedContent = Str::replaceArray('{{}}', [
            $fullNamespace,                        // Namespace
            $this->module_name,                    // Use Model
            $formNamespaceForUse,                  // Use Form namespace
            $this->module_name,                    // Class
            Str::lower($this->module_name),        // module_name property
            Str::plural(Str::lower($this->module_name)), // module_name_plural property
            $this->module_name,                    // Form type hint
            $this->module_name,                    // Redirect Index in update()
            $this->module_name,                    // Redirect Index in deleteConfirmed()
            $viewPath,                             // view path: admin.user
            Str::kebab($this->module_name),        // view file: user
        ], $content);

        $this->createFile($destination, $replacedContent, 'Edit class');
    }

    /**
     * Generate the EditForm object.
     *
     * Crea el Form Object que maneja la validación y actualización
     * de registros existentes en la base de datos.
     */
    protected function generateEditFormClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.edit.form.stub');

        // Construye el path del archivo de forma dinámica
        $formPath = $this->form_namespace
            ? str_replace('\\', '/', $this->form_namespace)
            : ($this->module_namespace ? str_replace('\\', '/', $this->module_namespace) : '');

        $destination = app_path("Livewire/Forms/{$formPath}/{$this->module_name}EditForm.php");

        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        $content = $this->file->get($stubPath);

        $replacedContent = Str::replaceArray('{{}}', [
            $this->form_namespace ?: ($this->module_namespace ?: ''), // Namespace for form
            $this->module_name,                    // Use Model
            $this->module_name,                    // Class name
            $this->module_name,                    // Model type hint setModel
            $this->module_name,                    // Model type hint update
            $this->module_name,                    // Variable $model
        ], $content);

        $this->createFile($destination, $replacedContent, 'EditForm class');
    }

    /**
     * Generate the Show Livewire component.
     *
     * Crea el componente de visualización en modo solo lectura
     * para mostrar los detalles de un registro.
     */
    protected function generateShowClass(): void
    {
        $stubPath = base_path('stubs/livewire.crud.show.stub');

        // Construye el path del archivo de forma dinámica
        $relativePath = $this->module_namespace
            ? str_replace('\\', '/', $this->module_namespace) . '/' . $this->module_name
            : $this->module_name;
        $destination = app_path("Livewire/{$relativePath}/{$this->module_name}Show.php");

        if (!$this->shouldCreateFile($destination)) {
            return;
        }

        $content = $this->file->get($stubPath);

        // Construye el namespace completo
        $fullNamespace = $this->module_namespace
            ? $this->module_namespace . '\\' . $this->module_name
            : $this->module_name;

        // Construye el path de la vista usando puntos (notación de Laravel)
        $viewPath = $this->module_view_path
            ? str_replace('/', '.', $this->module_view_path) . '.' . Str::kebab($this->module_name)
            : Str::kebab($this->module_name);

        $replacedContent = Str::replaceArray('{{}}', [
            $fullNamespace,                        // Namespace
            $this->module_name,                    // Use Model
            $this->module_name,                    // Class
            Str::lower($this->module_name),        // module_name property
            Str::plural(Str::lower($this->module_name)), // module_name_plural property
            $this->module_name,                    // Model route binding
            $viewPath,                             // view path: admin.user
            Str::kebab($this->module_name),        // view file: user
        ], $content);

        $this->createFile($destination, $replacedContent, 'Show class');
    }

    /**
     * Generate all CRUD Blade view files.
     *
     * Genera las siguientes vistas Blade:
     * - {module}-index.blade.php: Vista principal del módulo
     * - {module}-table.blade.php: Vista de la tabla de datos
     * - {module}-create.blade.php: Vista del formulario de creación
     * - {module}-edit.blade.php: Vista del formulario de edición
     * - {module}-show.blade.php: Vista de detalles/visualización
     *
     * La mayoría de las vistas se copian directamente, excepto index
     * que requiere reemplazo de placeholders para el componente de tabla.
     */
    protected function generateLivewireCrudViewFile(): void
    {
        $kebabName = Str::kebab($this->module_name);

        // Construye el path base de las vistas de forma dinámica
        $viewBasePath = $this->module_view_path
            ? resource_path("views/livewire/{$this->module_view_path}/{$kebabName}")
            : resource_path("views/livewire/{$kebabName}");

        // Define los archivos de vista a generar
        $views = [
            'index' => ['stub' => 'livewire.crud.index.view.stub', 'name' => 'Index view', 'needs_replacement' => true],
            'table' => ['stub' => 'livewire.crud.table.view.stub', 'name' => 'Table view', 'needs_replacement' => false],
            'create' => ['stub' => 'livewire.crud.create.view.stub', 'name' => 'Create view', 'needs_replacement' => false],
            'edit' => ['stub' => 'livewire.crud.edit.view.stub', 'name' => 'Edit view', 'needs_replacement' => false],
            'show' => ['stub' => 'livewire.crud.show.view.stub', 'name' => 'Show view', 'needs_replacement' => false],
        ];

        // Genera cada vista
        foreach ($views as $type => $config) {
            $stubPath = base_path("stubs/{$config['stub']}");
            $destination = "{$viewBasePath}/{$kebabName}-{$type}.blade.php";

            if (!$this->shouldCreateFile($destination)) {
                continue;
            }

            // Lee el contenido del stub
            $content = $this->file->get($stubPath);

            // Si la vista requiere reemplazo de placeholders (como index)
            if ($config['needs_replacement']) {
                // Construye la ruta del componente de forma dinámica
                $componentPath = $this->module_view_path
                    ? str_replace('/', '.', $this->module_view_path) . '.' . $kebabName
                    : $kebabName;

                $content = Str::replaceArray('{{}}', [
                    $componentPath,     // e.g., admin.user o product
                    $kebabName,         // e.g., user-table o product-table
                ], $content);
            }

            $this->createFile($destination, $content, $config['name']);
        }
    }

    /**
     * Check if a file should be created.
     *
     * Verifica si el archivo ya existe y cómo proceder según la opción --force.
     *
     * @param  string  $destination  Ruta completa del archivo a crear
     * @return bool True si se debe crear el archivo, false si se debe omitir
     */
    protected function shouldCreateFile(string $destination): bool
    {
        // Si el archivo no existe, se puede crear sin problema
        if (!$this->file->exists($destination)) {
            return true;
        }

        // Si existe y no se pasó la opción --force, se omite
        if (!$this->option('force')) {
            $this->filesSkipped++;
            $this->warn("⊘ Skipped (already exists): {$destination}");

            return false;
        }

        // Si existe pero se pasó --force, se sobrescribirá
        return true;
    }

    /**
     * Create a file with the given content.
     *
     * Crea el archivo en el sistema de archivos, asegurándose de que
     * el directorio padre exista antes de escribir.
     *
     * @param  string  $destination  Ruta completa del archivo
     * @param  string  $content  Contenido del archivo
     * @param  string  $description  Descripción del archivo para mensajes
     */
    protected function createFile(string $destination, string $content, string $description): void
    {
        try {
            // Asegura que el directorio padre exista
            $this->file->ensureDirectoryExists(dirname($destination));

            // Escribe el contenido en el archivo
            $this->file->put($destination, $content);

            // Incrementa contador y muestra mensaje de éxito
            $this->filesCreated++;
            $this->line("  ✓ Created: {$description}");
        } catch (\Exception $e) {
            // Captura cualquier error y lo registra
            $error = "Failed to create {$description}: {$e->getMessage()}";
            $this->errors[] = $error;
            $this->error("  ✗ {$error}");
        }
    }

    /**
     * Display operation summary.
     *
     * Muestra un resumen detallado de la operación:
     * - Cantidad de archivos creados
     * - Cantidad de archivos omitidos
     * - Lista de errores (si los hay)
     * - Próximos pasos sugeridos
     */
    protected function displaySummary(): void
    {
        $this->newLine();
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('  Operation Summary');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // Muestra estadísticas
        if ($this->filesCreated > 0) {
            $this->info("✓ Files created: {$this->filesCreated}");
        }

        if ($this->filesSkipped > 0) {
            $this->warn("⊘ Files skipped: {$this->filesSkipped}");
            $this->comment('  (Use --force to overwrite existing files)');
        }

        // Muestra errores si los hay
        if (!empty($this->errors)) {
            $this->newLine();
            $this->error('✗ Errors encountered: ' . count($this->errors));
            foreach ($this->errors as $error) {
                $this->line("  - {$error}");
            }
        }

        // Mensaje final
        $this->newLine();
        if (empty($this->errors) && $this->filesCreated > 0) {
            $this->info('✓ CRUD module generated successfully!');
            $this->newLine();

            // Sugerencias de próximos pasos
            $this->comment('Next steps:');
            $this->line("  1. Create the {$this->module_name} model if it doesn't exist:");
            $this->line("     php artisan make:model {$this->module_name} -mf");
            $this->newLine();

            if ($this->with_forms) {
                $this->line('  2. Update the Form Objects with your specific validation rules');

                $formPath = $this->form_namespace
                    ? str_replace('\\', '/', $this->form_namespace)
                    : ($this->module_namespace ? str_replace('\\', '/', $this->module_namespace) : '');

                $formPathDisplay = $formPath ? $formPath . '/' : '';

                $this->line("     - app/Livewire/Forms/{$formPathDisplay}{$this->module_name}CreateForm.php");
                $this->line("     - app/Livewire/Forms/{$formPathDisplay}{$this->module_name}EditForm.php");
                $this->newLine();
            }

            $this->line('  ' . ($this->with_forms ? '3' : '2') . '. Customize the views to match your requirements');
            $viewPath = $this->module_view_path
                ? $this->module_view_path . '/' . Str::kebab($this->module_name)
                : Str::kebab($this->module_name);
            $this->line("     - resources/views/livewire/{$viewPath}/");
            $this->newLine();

            $this->line('  ' . ($this->with_forms ? '4' : '3') . '. Add routes to your routes file:');

            $routeName = Str::kebab(Str::plural($this->module_name));
            $componentClass = $this->module_namespace
                ? $this->module_namespace . '\\' . $this->module_name . '\\' . $this->module_name . 'Index'
                : $this->module_name . 'Index';

            $this->line("     Route::get('/{$routeName}', {$componentClass}::class)->name('{$routeName}.index');");
        } elseif ($this->filesSkipped > 0 && $this->filesCreated === 0) {
            $this->warn('⊘ No files were created (all files already exist)');
        }

        $this->newLine();
    }
}
