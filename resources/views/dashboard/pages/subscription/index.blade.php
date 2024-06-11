@extends('layouts.dashboard.app')
@section('page-header', __('theme/plans.title'))
@section('js')
    <script>
        var user_plan = "<?php echo \Illuminate\Support\Facades\Auth::user()->plan_id; ?>";
        var accept_downgrade = false;
        var plan = "";
        var url = "<?php echo env('APP_URL'); ?>";

        $(document).ready(function() {
            $('#ozel-message').val('{{ __('theme/plans.i-would-like-to-know-more-about-the-custom-plan') }}');
            $('#123456789').click(function() {
                var textToCopy = '';
                var $tempInput = $('<input>');
                $('body').append($tempInput);
                $tempInput.val(textToCopy).select();
                document.execCommand('copy');
                $tempInput.remove();
            });
            $('#email-form').submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting normally
                $.ajax({
                    url: $(this).attr('action'), // The form's action URL
                    method: $(this).attr('method'), // The form's HTTP method
                    data: $(this).serialize(), // Serialize the form data for the AJAX request
                    success: function(response) {
                        alert('Email sent successfully!'); // Show a success message to the user
                    },
                    error: function(xhr) {
                        $('#successful-message').css('display', 'block');
                    }
                });
            });
            switch (user_plan) {
                case '2':
                    $('#temel-plan').prop('disabled', true)
                    $("#temel-plan").text('{{ __('theme/plans.current-plan') }}');
                    $("#temel-plan").css("background-color",
                        "background: linear-gradient(to top, #e6e9f0 0%, #eef1f5 100%)");
                    $(".temel").css("background", "#b3b3b3");

                    break;

                case '3':
                    $('#professional-plan').prop('disabled', true)
                    $("#professional-plan").text('{{ __('theme/plans.current-plan') }}');
                    $(".professional").css("background", "#b3b3b3");
                    break;

                case '4':
                    $('#premium-plan').prop('disabled', true)
                    $("#premium-plan").text('{{ __('theme/plans.current-plan') }}');
                    $(".premium").css("background", "#b3b3b3");
                    break;

            }
            $('#PaymentModal').on('hidden.bs.modal', function() {
                location.reload(); // Reload the page
            });
            $('#downgrade_modal').on('hidden.bs.modal', function() {
                $("#keyword-usage").html("");
            });
        });

        $(document).on('click', '#downgrade_plan', function() {
            accept_downgrade = true;
            $('#downgrade_modal').modal('hide');
            changePlan(plan);
        });

        function changePlan(planName) {
            $(".plan-title").html("");
            var firstWord = planName.replace(/ .*/, '');
            $(".plan-title").prepend(firstWord + " {{ __('theme/plans.pay-for-subscription') }}");
            plan = planName


            $.ajax({
                url: '/dashboard/order/' + planName,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    plan: planName,
                    accept_downgrade: accept_downgrade,
                },
                success: function(response) {
                    console.log(response);
                    if (response.show_downgrade_modal === 200) {
                        if (response.user_keywords_counter > response.plan_keyword_limit) {
                            var keywordUsage = $('#keyword-usage');
                            keywordUsage.html(keywordUsage.html() + "<ul><li>" + planName +
                                " {{ __('theme/plans.pay-for-subscription') }} " + response
                                .plan_keyword_limit +
                                "'{{ __('theme/plans.stop-and-your-current-keyword-count') }} " + response
                                .user_keywords_counter +
                                "'{{ __('theme/plans.therefore-in-the-next-reports') }} " + response
                                .plan_keyword_limit + " {{ __('theme/plans.your-keyword-will-be') }}." +
                                "</li></ul>");
                        }
                        $('#downgrade_modal').modal('show');
                    } else {
                        document.getElementById("iyzico-iframe").src = url + "/dashboard/order/" + planName
                        $('#PaymentModal').modal('show');
                    }
                },
                error: function(xhr) {
                    console.log('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        }
    </script>
    <script>
        $('#error-message').hide();
        $('#success-message').hide();
        $(".btn-submit").click(function(e) {
            var _token = $("input[name='_token']").val();
            e.preventDefault();

            var email = $("#email").val();
            var name = $("#name").val();
            var message = $("#ozel-message").val();

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
                    $('#error-message').hide();
                    $('#success-message').show();
                    setTimeout(function() {
                        $(".button-close").click();
                        $('#success-message').hide();
                        $('#message').val('');
                    }, 5000);
                },
                error: function() {
                    $('#success-message').hide();
                    $('#error-message').show();
                }
            });
        });
    </script>
@endsection
@section('content')
    <div class="modal fade" id="transfer-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="padding: 10px">
                <div class="modal-body">
                    <div class="alert alert-success" id="successful-message" role="alert" style="display: none">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                            aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        {{ __('theme/plans.email-sent-successfully') }}
                    </div>
                    <p style="font-weight: bold">{{ __('theme/plans.bank-transfer') }}</p>
                    <span
                        style="font-size: 14px;color: #75808a">{{ __('theme/plans.make-transfer-to-the-account-details-provided') }}</span>
                    <div class="container"
                        style="background-color: #f2f2f2;padding: 20px;margin-top: 30px;border-radius: 10px">
                        <div class="row" style="color: #75808a;font-size: 14px">
                            <div class="col-lg-6">
                                <span>{{ __('theme/plans.account-number') }}</span>
                            </div>
                            <div class="col-lg-6">
                                <span style="float: right">{{ __('theme/plans.bank-name') }}</span>
                            </div>
                        </div>
                        <div class="row" style="font-weight: bold;font-size: 16px;margin-top: 10px;">
                            <div class="col-lg-6">
                                <span id="accountNumber">123456789</span>
                                <button id="123456789" style="background: transparent;border: none">
                                    <i class="fa-solid fa-clone fa" style="color: #3c44bc;"></i>
                                </button>
                            </div>
                            <div class="col-lg-6">
                                <span style="float: right">Ziraat Bankası</span>
                            </div>
                        </div>
                        <div class="row" style="color: #75808a;font-size: 14px;margin-top: 15px;">
                            <div class="col-lg-6">
                                <span>{{ __('theme/plans.account-name') }}</span>
                            </div>
                            <div class="col-lg-6">
                                <span style="float: right">IBAN</span>
                            </div>
                        </div>
                        <div class="row" style="font-weight: bold;font-size: 16px;margin-top: 10px;">
                            <div class="col-lg-6">
                                <span id="accountNumber">Marka.Takip legal</span>
                            </div>
                            <div class="col-lg-6">
                                <span style="float: right">TR123423423422343</span>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center;margin-top: 30px;color:#3c44bc ">
                        <p>
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            {{ __('theme/plans.if-you-have-other-payment-requirements') }}
                        </p>
                    </div>
                    <div style="margin-top: 30px">
                        <form method="POST" action="{{ route('send.email', ['language' => app()->getLocale()]) }}"
                            id="email-form">
                            @csrf
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="recipient_email"> {{ __('theme/plans.email') }}</label>
                                <input type="email" class="form-control"
                                    value="{{ \Illuminate\Support\Facades\Auth::user()->email }}" id="recipient_email"
                                    name="recipient_email" disabled>
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                <label for="subject">İsim</label>
                                <input type="text" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}"
                                    class="form-control" id="name" name="name" required disabled>
                            </div>

                            <div class="form-group" style="margin-top: 25px;">
                                <label for="message"> {{ __('theme/plans.message') }}</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div style="display: grid;margin-top: 10px;">
                                <button type="submit" class="btn btn-primary"
                                    style="margin-top: 25px;">{{ __('theme/plans.send') }}</button>
                                <button type="button" class="btn btn-outline-dark btn-md" style="margin-top: 10px"
                                    data-dismiss="modal">{{ __('theme/plans.close') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cards">
        <div class="card shadow col-xxl-3 col-xl-4 col-md-4 col-sm-12 mx-2">
            <ul class="price-list" style="text-align: center">
                <li class="pack">{{ __('theme/plans.basic') }}</li>
                <li id="basic" class="price bottom-bar">235 TL/{{ __('theme/plans.month') }}</li>
                <li class="bottom-bar">200 {{ __('theme/plans.brand') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.monthly-current-tracking') }}</span>
                </li>
                <li class="bottom-bar">10 {{ __('theme/plans.shape') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.monthly-tracking') }}</span></li>
                <li class="bottom-bar">20 {{ __('theme/plans.call') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.manual-search-in-past-bulletins') }}</span>
                </li>
                <li class="bottom-bar">10 {{ __('theme/plans.search-by-shape') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.manual-search-in-past-bulletins') }}</span>
                </li>
                <li class="bottom-bar"><span
                        class="price-list-subtitle">{{ __('theme/plans.all-limits-are-refilled-monthly') }}.</span>
                </li>
                <li>
                    <button class="learn-more-btn temel" onclick="changePlan('Temel Plan')" value="Abone ol"
                        id="temel-plan">
                        {{ __('theme/plans.subscribe') }}
                    </button>
                </li>
            </ul>
        </div>
        <div class="card shadow col-xxl-3 col-xl-4 col-md-4 col-sm-12 mx-2 ">
            <ul class="price-list" style="text-align: center">
                <li class="pack">{{ __('theme/plans.professional') }}</li>
                <li id="basic" class="price bottom-bar">585 TL/{{ __('theme/plans.month') }}</li>
                <li class="bottom-bar">1500 {{ __('theme/plans.brand') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.monthly-current-tracking') }}</span></li>
                <li class="bottom-bar">75 {{ __('theme/plans.shape') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.monthly-current-tracking') }}</span></li>
                <li class="bottom-bar">200 {{ __('theme/plans.call') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.manual-search-in-past-bulletins') }}</span></li>
                <li class="bottom-bar">40 {{ __('theme/plans.search-by-shape') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.manual-search-in-past-bulletins') }}</span><br>
                </li>
                <li class="bottom-bar"><span
                        class="price-list-subtitle">{{ __('theme/plans.all-limits-are-refilled-monthly') }}.</span></li>
                <li>
                    <button class="learn-more-btn professional" onclick="changePlan('Profesyonel Plan')"
                        id="professional-plan">
                        {{ __('theme/plans.subscribe') }}
                    </button>
                </li>
            </ul>
        </div>
        <div class="card shadow col-xxl-3 col-xl-4 col-md-4 col-sm-12 mx-2 price-list">
            <ul class="price-list" style="text-align: center">
                <li class="pack">{{ __('theme/plans.premium') }}</li>
                <li id="basic" class="price bottom-bar">820 TL/{{ __('theme/plans.month') }}</li>
                <li class="bottom-bar">5000 {{ __('theme/plans.brand') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.monthly-current-tracking') }}</span></li>
                <li class="bottom-bar">1000 {{ __('theme/plans.shape') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.monthly-current-tracking') }}</span></li>
                <li class="bottom-bar">500 {{ __('theme/plans.call') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.manual-search-in-past-bulletins') }}</span></li>
                <li class="bottom-bar">200 {{ __('theme/plans.search-by-shape') }}<br><span
                        class="price-list-subtitle">{{ __('theme/plans.manual-search-in-past-bulletins') }}</span><br>
                </li>
                <li class="bottom-bar">100 {{ __('theme/plans.area-scan') }}</li>
                <li class="bottom-bar"><span
                        class="price-list-subtitle">{{ __('theme/plans.all-limits-are-refilled-monthly') }}.</span></li>
                <li>
                    <button class="learn-more-btn premium" onclick="changePlan('Premium Plan')" id="premium-plan">
                        {{ __('theme/plans.subscribe') }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="modal fade" id="PaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title plan-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="iyzico-iframe"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-12 mx-2" style="margin-top: 15px;text-align: center;">
        <span style="font-size: 16px">
            {{ __('theme/plans.need-a-different-plan') }} <a style="text-decoration: underline" href="#"
                data-toggle="modal" data-target="#contact-subscription-modal"> {{ __('theme/plans.get-an-offer') }}. </a>
        </span>
        <br>
        <div style="margin-top: 10px;">
            <span style="margin-top: 100px!important;font-size: 16px">
                {{ __('theme/plans.instead-of-credit-debit-cards') }}
                <a href="#" data-toggle="modal"
                    data-target="#transfer-modal">{{ __('theme/plans.other-payment-methods') }}</a>
                {{ __('theme/plans.do-you-want-to-use') }}
            </span>
        </div>
    </div>
    <form>
        @csrf
        <div class="modal fade" id="contact-subscription-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="ozel-plan" class="card-heading">{{ __('theme/plans.special-plan') }}</h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body" style="padding:0!important;">
                            <div class="alert alert-success" id="success-message">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                {{ __('theme/plans.your-message-has-been-sent-successfully') }}
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1"
                                    class="form-label">{{ __('theme/plans.name') }}</label>
                                <input type="name" name="name" id="name" class="form-control"
                                    value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1"
                                    class="form-label">{{ __('theme/plans.email') }}</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ auth()->user()->email }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1"
                                    class="form-label">{{ __('theme/plans.message') }}</label>
                                <textarea class="form-control" id="ozel-message" name="ozel-message" rows="5" required></textarea>
                                <span class="text-danger"
                                    id="error-message">*{{ __('theme/plans.please-enter-a-message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-submit" style="float: left"
                            class="btn btn-primary btn-submit">{{ __('theme/landing.contact-form.submit') }}</button>
                        <button type="button" class="btn btn-secondary button-close"
                            data-dismiss="modal">{{ __('theme/settings.close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="downgrade_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-body" style="padding:15px!important;">
                        <div>
                            <h4>{{ __('theme/plans.plan-downgrade') }}</h4>
                            <br>
                            <p>
                                {{ __('theme/plans.are-you-sure-you-want-to-downgrade') }}.
                            </p>
                            <p id="keyword-usage">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #eeeff6">
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">
                        {{ __('theme/settings.close') }}
                    </button>
                    <button type="button" class="btn btn-primary" id="downgrade_plan" style="color: white">
                        {{ __('theme/plans.change') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .checkbox:checked+.sub {
        justify-content: flex-end;
    }

    .cards {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .card {
        max-width: 350px;
        /*margin: 10px;*/
        background: #fff;
        color: hsl(233, 13%, 49%);
        border-radius: 0.8rem;
    }

    .cardd {
        background: #fff;
        color: hsl(233, 13%, 49%);
        border-radius: 0.8rem;
    }

    ul.price-list {
        margin: 3rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
    }

    .close {
        background: transparent;
        border: 0;
        font-size: 25px;
    }

    ul.price-list li {
        list-style-type: none;
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 1rem 0;
        margin-right: 20px;
    }

    ul.price-list li.price {
        font-size: 2.3rem;
        color: hsl(232, 13%, 33%);
        padding-bottom: 2rem;
    }

    .shadow {
        box-shadow: -5px 5px 15px 1px rgba(0, 0, 0, 0.1);
    }

    .card.active .price {
        color: #fff;
    }

    .learn-more-btn {
        height: 2.6rem;
        width: 13.3rem;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 4px;
        background: linear-gradient(135deg,
                rgba(163, 168, 240, 1) 0%,
                rgba(105, 111, 221, 1) 100%);
        color: #fff;
        outline: none;
        border: 0;
        font-weight: bold;
        margin-top: 25%;
        transition: all 0.2s ease-in-out;
        /* Set the transition effect */
    }

    .learn-more-btn:hover {
        transform: scale(1.04);
        /* Add a scale animation on hover */
    }

    .premium {
        margin-top: 0%;
    }

    .bize {
        margin-top: 0% !important;
    }

    button.learn-more-btn.subscription-active-btn {
        background: #fff;
        color: hsl(237, 63%, 64%);
    }

    .bottom-bar {
        border-bottom: 2px solid hsla(240, 8%, 85%, 0.582);
    }

    .card.active .bottom-bar {
        border-bottom: 2px solid hsla(240, 8%, 85%, 0.253);
    }

    .pack {
        font-size: 1.1rem;
    }

    @media (min-width: 414px) and (max-width: 768px) {
        .card {
            margin-bottom: 1rem;
            margin-right: 1rem;
        }

        .cards .card.active {
            transform: scale(1);
        }
    }

    @media (min-width: 768px) and (max-width: 1046px) {
        .cards {
            display: flex;
        }

        .card {
            margin-bottom: 1rem;
            margin-right: 1rem;
        }

        .cards .card.active {
            transform: scale(1);
        }
    }

    @media (max-width: 400px) {
        .card {
            margin-right: 0;
            margin-left: 0;
            margin-top: 10px;
        }
    }

    #iyzico-iframe {
        width: 100%;
        height: 780px;
        background-color: white !important;
        position: relative;
    }

    #myIframe iframe {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .price-list-subtitle {
        display: contents;
        font-size: 11px;
    }

    @media screen and (max-width: 1400px) {
        .price-list {
            margin-top: 10px;
        }
    }
</style>
