<div class="sidebar py-3" id="sidebar">
    <h6 class="sidebar-heading">{{ __('theme/sidebar.heading') }}</h6>
    <ul class="list-unstyled tour-menu">
        @role('super admin|admin')
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted" href="{{ route('user.index', ['language' => app()->getLocale()]) }}">
                    <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#user-1"></use>
                    </svg>{{ __('theme/sidebar.pages.users') }}</a>
            </li>
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted" href="{{ route('bulletin.index', ['language' => app()->getLocale()]) }}">
                    <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#statistic-1">
                        </use>
                    </svg>{{ __('theme/sidebar.pages.bulletins') }}</a>
            </li>
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted" href="{{ route('contact.index', ['language' => app()->getLocale()]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon svg-icon-md me-3" viewBox="0 0 64 64"
                        aria-labelledby="title" aria-describedby="desc" role="img"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path data-name="layer2" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2"
                            d="M2 12l30 29 30-29M42 31.6L62 52M2 52l20-20.4" stroke-linejoin="round" stroke-linecap="round">
                        </path>
                        <path data-name="layer1" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2"
                            d="M2 12h60v40H2z" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>{{ __('theme/sidebar.pages.contact-form') }}</a>
            </li>
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted" href="{{ route('error.index', ['language' => app()->getLocale()]) }}">
                    <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#statistic-1">
                        </use>
                    </svg>{{ __('theme/sidebar.pages.errors') }}</a>
            </li>
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted" href="{{ route('plans.index', ['language' => app()->getLocale()]) }}">
                    <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#statistic-1">
                        </use>
                    </svg>{{ __('theme/sidebar.pages.plans') }}</a>
            </li>
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted" href="{{ route('articles.index', ['language' => app()->getLocale()]) }}">
                    <svg class="svg-icon svg-icon-md me-3">
                        <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#numbers-1">
                        </use>
                    </svg>Articles</a>
            </li>
            <hr>
        @endrole
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-keyword"
                href="{{ route('keyword.create', ['language' => auth()->user()->language]) }}">
                <svg class="svg-icon svg-icon-md me-3">
                    <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#reading-1">
                    </use>
                </svg>{{ __('theme/sidebar.pages.keywords') }}</a>
        </li>
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-report"
                href="{{ route('report.index', ['language' => auth()->user()->language]) }}">
                <svg class="svg-icon svg-icon-md me-3">
                    <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#statistic-1">
                    </use>
                </svg>{{ __('theme/sidebar.pages.reports') }}</a>
        </li>
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-report"
                href="{{ route('image.index', ['language' => auth()->user()->language]) }}">
                <svg class="svg-icon svg-icon-md me-3">
                    <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#image-1">
                    </use>
                </svg>{{ __('theme/sidebar.pages.images') }}</a>
        </li>
        <hr>
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-classes"
                href="{{ route('dashboard.classes', ['language' => auth()->user()->language]) }}">
                <svg class="svg-icon svg-icon-md me-3">
                    <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#statistic-1">
                    </use>
                </svg>{{ __('theme/sidebar.pages.nice-classes') }}</a>
        </li>
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-search"
                href="{{ route('advanced-search', ['language' => auth()->user()->language]) }}">
                <svg class="svg-icon-md me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                    height="24">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15zm-3.847-8.699a2 2 0 1 0 2.646 2.646 4 4 0 1 1-2.646-2.646z"
                        fill="rgba(108,117,125,1)" />
                </svg>
                {{ __('theme/sidebar.pages.advanced-search') }}</a>
        </li>
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-search"
                href="{{ route('search', ['language' => auth()->user()->language]) }}">
                <svg class="svg-icon svg-icon-md me-3">
                    <use xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#search-1">
                    </use>
                </svg>{{ __('theme/sidebar.pages.search') }}</a>
        </li>
        @if (auth()->user()->plan->image_search_limit > 0)
        <li class="sidebar-list-item">
            <a class="sidebar-link text-muted tour-search"
                href="{{ route('image.search', ['language' => app()->getLocale()]) }}">
                <svg class="svg-icon-md me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                    height="24">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M15 4H5v16h14V8h-4V4zM3 2.992C3 2.444 3.447 2 3.999 2H16l5 5v13.993A1 1 0 0 1 20.007 22H3.993A1 1 0 0 1 3 21.008V2.992zm10.529 11.454a4.002 4.002 0 0 1-4.86-6.274 4 4 0 0 1 6.274 4.86l2.21 2.21-1.414 1.415-2.21-2.21zm-.618-2.032a2 2 0 1 0-2.828-2.828 2 2 0 0 0 2.828 2.828z"
                        fill="rgba(108,117,125,1)" />
                </svg>
                {{ __('theme/sidebar.pages.image-search') }}&nbsp; <span style="color:#DC143C; text-shadow:0 0 8px #DC143C;font-size:11px">(BETA)</span></a>
        </li>
        @endif
        @role('super admin|admin')
            <li class="sidebar-list-item">
                <a class="sidebar-link text-muted tour-search"
                    href="{{ route('landscape-search', ['language' => app()->getLocale()]) }}">
                    <svg class="svg-icon-md me-3"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                        height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M22 19v2h-2v-2H4v2H2v-2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h10.528A5.985 5.985 0 0 1 17 3c1.777 0 3.374.773 4.472 2H22a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1zM11.341 7H3v10h18v-3.528A6 6 0 0 1 11.341 7zM17 13a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM5 13h2v2H5v-2zm3 0h2v2H8v-2z"
                            fill="rgba(108,117,125,1)" />
                    </svg>
                    {{ __('theme/sidebar.pages.landscape-search') }}</a>
            </li>
        @endrole

        <hr>
        {{-- <li class="sidebar-list-item" style="cursor: pointer">
            <a class="sidebar-link text-muted tour-search" href="{{ route('subscription.list') }}">
                <svg class="svg-icon svg-icon-md me-3">
                    <use
                        xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#bank-cards-1">
                    </use>
                </svg>
                Abonelik Yönetimi
            </a>
        </li> --}}
        <li class="sidebar-list-item" style="cursor: pointer">
            <a class="sidebar-link text-muted tour-contact" data-bs-toggle="modal" data-bs-target="#contact-modal">
                <svg class="svg-icon svg-icon-md me-3">
                    <use
                        xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#question-help-1">
                    </use>
                </svg>
                {{ __('theme/sidebar.pages.contact-us') }}
            </a>
        </li>
    </ul>
</div>
<form>
    @csrf
    <div class="modal fade" id="contact-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="card-heading">{{ __('theme/sidebar.contact.title') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body" style="padding:0!important;">
                        <div class="alert alert-success" id="message-success">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            {{ __('theme/sidebar.contact.success') }}
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                {{ __('theme/sidebar.contact.name') }}
                            </label>
                            <input type="name" name="name" id="name" class="form-control"
                                value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                {{ __('theme/sidebar.contact.email') }}
                            </label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ auth()->user()->email }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">
                                {{ __('theme/sidebar.contact.message') }}
                            </label>
                            <textarea name="message" id="message" class="form-control" rows="5"></textarea>
                            <span class="text-danger" id="message-error">
                                {{ __('theme/sidebar.contact.please-enter-a-message') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-submit" style="float: left"
                        class="btn btn-primary btn-submit">{{ __('theme/sidebar.contact.send') }}</button>
                    <button type="button" class="btn btn-secondary close-button"
                        data-bs-dismiss="modal">{{ __('theme/sidebar.contact.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('#message-error').hide();
    $('#message-success').hide();
    $(".btn-submit").click(function(e) {
        var _token = $("input[name='_token']").val();
        e.preventDefault();

        var email = $("#email").val();
        var name = $("#name").val();
        var message = $("#message").val();

        $.ajax({
            type: 'POST',
            url: "{{ route('contact.form') }}",
            data: {
                _token: _token,
                email: email,
                name: name,
                message: message
            },
            success: function() {
                $('#message-error').hide();
                $('#message-success').show();
                setTimeout(function() {
                    $(".close-button").click();
                    $('#message-success').hide();
                    $('#message').val('');
                }, 5000);
            },
            error: function() {
                $('#message-success').hide();
                $('#message-error').show();
            }
        });
    });
</script>
