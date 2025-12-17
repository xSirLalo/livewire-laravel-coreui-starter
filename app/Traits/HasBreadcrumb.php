<?php

namespace App\Traits;

trait HasBreadcrumb
{
    /**
     * Get the breadcrumb items for the current module action.
     */
    public function getBreadcrumbItems(): array
    {
        $items = [];

        // Add the module list item
        $items[] = [
            'title' => __(ucfirst($this->module_name_plural)),
            'route' => route("admin.{$this->module_name}.index"),
            'active' => false,
        ];

        // Add the action item based on module_action
        $actionTitle = $this->getBreadcrumbActionTitle();

        if ($actionTitle) {
            $items[] = [
                'title' => __($actionTitle),
                'route' => null,
                'active' => true,
            ];
        }

        return $items;
    }

    /**
     * Get the breadcrumb action title based on module_action.
     */
    protected function getBreadcrumbActionTitle(): ?string
    {
        return match ($this->module_action) {
            'Create' => 'Create',
            'Edit' => 'Edit',
            'Detail', 'Show' => 'Detail',
            'List' => null, // No additional breadcrumb for list view
            default => $this->module_action,
        };
    }

    /**
     * Render the breadcrumb HTML.
     */
    public function renderBreadcrumb(): string
    {
        $items = $this->getBreadcrumbItems();
        $html = '';

        foreach ($items as $item) {
            if ($item['active']) {
                $html .= sprintf(
                    '<x-admin.breadcrumb-item type="active">%s</x-admin.breadcrumb-item>',
                    $item['title']
                );
            } else {
                $html .= sprintf(
                    '<x-admin.breadcrumb-item route="%s">%s</x-admin.breadcrumb-item>',
                    $item['route'],
                    $item['title']
                );
            }
        }

        return $html;
    }
}
