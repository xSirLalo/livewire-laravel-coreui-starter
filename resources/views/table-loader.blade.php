@props([
    'rows' => 5,
    'cols' => 4,
])

<div>
    <div class="row pb-3">
        <div class="col-md-auto">
            <div class="skeleton skeleton-input" style="width: 200px;"></div>
        </div>
        <div class="col-md-auto">
            <div class="skeleton skeleton-select" style="width: 80px;"></div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    @for ($i = 0; $i < $cols; $i++)
                        <th>
                            <div class="skeleton skeleton-header"></div>
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $rows; $i++)
                    <tr>
                        @for ($j = 0; $j < $cols; $j++)
                            <td>
                                <div class="skeleton skeleton-cell"></div>
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

@push('css')
    <style>
        .skeleton {
            background: #e1e1e1;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .skeleton-input {
            height: 38px;
        }

        .skeleton-select {
            height: 38px;
        }

        .skeleton-header {
            height: 20px;
            width: 80%;
            margin: 0 auto;
        }

        .skeleton-cell {
            height: 16px;
            width: 90%;
            margin: 8px auto;
        }

        .skeleton::before {
            content: "";
            display: block;
            position: absolute;
            left: -150px;
            top: 0;
            height: 100%;
            width: 150px;
            background: linear-gradient(to right,
                    transparent 0%,
                    #e8e8e8 50%,
                    transparent 100%);
            animation: skeleton-load 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }

        @keyframes skeleton-load {
            from {
                left: -150px;
            }

            to {
                left: 100%;
            }
        }
    </style>
@endpush
