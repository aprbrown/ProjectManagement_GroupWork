<div class="card mb-3">
    <div class="card-header">
        {{ $heading }}
    </div>

    <div class="card-body">
        {{ str_limit($body, $words = 50, $end = '...') }}
    </div>
</div>