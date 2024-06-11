<header class="header">
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow">
        <a class="sidebar-toggler text-gray-500 me-4 me-lg-5 lead" href="#">
            <i class="fas fa-align-left"></i>
        </a>
        <a class="" href="{{ route('dashboard.index', ['language' => auth()->user()->language]) }}">
            <img style="max-width: 45%" src="{{ asset('assets/dashboard') }}/img/takip-marka-legal-blue-logo.png"
                alt="logo">
        </a>
        <a class="navbar-brand fw-bold text-uppercase text-base"
            href="{{ route('dashboard.index', ['language' => auth()->user()->language]) }}">
            <span class="d-none d-brand-partial">{{ auth()->user()->name }}</span>
        </a>
        <ul class="ms-auto d-flex align-items-center list-unstyled mb-0">
            <li class="nav-item dropdown ms-auto tour-settings">
                <form id="language-form" method="GET">
                    <select id="language-select" class="nav-item form-select" onchange="changeLanguage()">
                        @foreach(config('app.languages') as $locale => $label)
                                <option value="{{ $locale }}" {{ App::getLocale() === $locale ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                    </select>
                </form>
            </li>
            <li class="nav-item dropdown ms-auto tour-settings">
                <a class="nav-link pe-0" id="userInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="avatar p-1" src="{{ asset('assets/dashboard') }}/img/blank-avatar.png"
                        alt="{{ auth()->user()->name }}">
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="userInfo">
                    <div class="dropdown-header text-gray-700">
                        <h6 class="text-uppercase font-weight-bold"> {{ auth()->user()->name }} </h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item"
                        href="{{ route('settings', ['language' => auth()->user()->language]) }}">{{ __('theme/navbar.settings') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item"
                        href="{{ route('logout', ['language' => auth()->user()->language]) }}">{{ __('theme/navbar.logout') }}</a>
                </div>
            </li>
        </ul>
    </nav>
</header>
<script>
    function changeLanguage() {
        const old_language = "{{ App::getLocale() }}"
        const new_language = document.getElementById('language-select');

        $.ajax({
            url: "{{ route('language.update', ['language' => auth()->user()->language]) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                language: new_language.value,
            },
            success: function(response) {
                const new_language = response.new_language;
                const new_url = window.location.href.replace('/' + old_language + '/', '/' + new_language +
                    '/');
                window.location.href = new_url;
            }
        });
    }
</script>
