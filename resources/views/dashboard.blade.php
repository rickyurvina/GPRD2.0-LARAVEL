
<div>
    @if(!currentUser()->hasRole('developer'))
        @if(session()->get('module')->id == \App\Models\System\Module::MODULE_GXR)
            @include('dashboard.planning.index')
        @elseif(session()->get('module')->id == \App\Models\System\Module::MODULE_ROADS)
            @include('default_dashboard_roads')
        @elseif(session()->get('module')->id == \App\Models\System\Module::MODULE_CONFIGURATION)
            @include('dashboard.configuration.landing')
        @elseif(session()->get('module')->id == \App\Models\System\Module::MODULE_APP)
            @include('dashboard.app.index')
        @else
            @include('default_dashboard')
        @endif
    @endif
</div>

<script>
    $(() => {
        hideLoading();
    });
</script>
