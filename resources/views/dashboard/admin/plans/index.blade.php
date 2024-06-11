@extends('layouts.dashboard.app')
@section('page-header', 'PLANLAR')
@section('js')
    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'inline';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        var language = '{{ app()->getLocale() }}';

        $('.updateSearchLimit').editable({
            url: "{{ route('plans-search-limit.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'searchlimit',
            title: 'Test Limit',
            success: function(response, newValue) {
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("Girilen değer 0 ile 100 arasında olmalıdır.")
            }
        });

        $('.updateLandscapeSearchLimit').editable({
            url: "{{ route('plans-search-limit.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'searchlimit',
            title: 'Test Limit',
            success: function(response, newValue) {
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("Girilen değer 0 ile 100 arasında olmalıdır.")
            }
        });

        $('.updateSearchLimit').editable({
            url: "{{ route('plans-search-limit.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'searchlimit',
            title: 'Test Limit',
            success: function(response, newValue) {
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("Girilen değer 0 ile 100 arasında olmalıdır.")
            }
        });

        $('.updateKeywordLimit').editable({
            url: "{{ route('plans-keyword-limit.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'keywordlimit',
            title: 'Keyword Limit',
            success: function(response, newValue) {
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("Girilen değer 0 ile 100 arasında olmalıdır.")
            }
        });

        $('.updatePlanName').editable({
            url: "{{ route('plans-name.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'planName',
            title: 'Plan Name',
            success: function(response, newValue) {
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("plan adı alanı boş olamaz.")
            }
        });

        $(".btn-submit").click(function(e){
            var _token = $("input[name='_token']").val();
            e.preventDefault();

            var planName = $("#plan-name").val();
            var testLimit = $("#test-limit").val();
            var keywordLimit = $("#keyword-limit").val();

            $.ajax({
                type:'POST',
                url: "{{ route('plans.store', ['language' => app()->getLocale()]) }}",
                data:{_token:_token,plan_name:planName, search_limit:testLimit,keyword_limit:keywordLimit},
                success:function(){
                    $("#loadTable").load(location.href + " #loadTable");
                    document.getElementById('successful-message').style.display = "block";
                },
                error: function (data) {
                    // Handle error response
                }
            });
        });
    </script>
@endsection
@section('content')
    <section id="loadTable">
        <div class="card card-table mb-4">
            <?php if(Session::has('error')): ?>
            <div class="alert alert-danger" id="message_id">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                    <?php echo e(Session::get('error')); ?>

                    <?php
                    Session::forget('error');
                    ?>
            </div>
            <?php endif; ?>
            <div class="card-header">
                <button type="button" style="float:right" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-plan"
                >
                    Yeni Plan Ekle
                </button>
                <h5 class="card-heading"> PLANLAR</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="text-align: center">
                        <thead>
                        <tr>
                            <th>SIRA</th>
                            <th>PLAN</th>
                            <th>TEST LİMİTİ	</th>
                            <th>ANAHTAR KELİME LİMİTİ</th>
                            <th>ALAN TARAMA LİMİTİ</th>
                            <th>ŞEKİL İLE ARAMA LİMİTİ</th>
                            <th colspan=2>İŞLEMLER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($plans as $key=>$plan)
                            <tr class="align-middle">
                                <td>#{{$key+1}}</td>
                                @if($plan->plan_name !='Özel Plan')
                                    <td><a href="" class="updatePlanName" data-name="planName" data-type="text" data-pk="{{ $plan->id }}" data-title="Plan Name">{{ $plan->plan_name }}</a></td>
                                @else
                                    <td><a href="" class="updatePlanName">{{ $plan->plan_name }}</a></td>
                                @endif
                                <td><a href="" class="updateSearchLimit" data-name="searchlimit" data-type="text" data-pk="{{ $plan->id }}" data-title="Test Limit">{{ $plan->search_limit }}</a></td>
                                <td><a href="" class="updateLandscapeSearchLimit" data-name="keywordlimit" data-type="text" data-pk="{{ $plan->id }}" data-title="Keyword Limit">{{ $plan->landscape_limit }}</a></td>
                                <td><a href="" class="updateKeywordLimit" data-name="keywordlimit" data-type="text" data-pk="{{ $plan->id }}" data-title="Keyword Limit">{{ $plan->keyword_limit }}</a></td>
                                <td><a href="" class="updateImageSearchLimit" data-name="keywordlimit" data-type="text" data-pk="{{ $plan->id }}" data-title="Keyword Limit">{{ $plan->image_search_limit }}</a></td>
                                <td>
                                    <form action="{{ route('plans.destroy', ['language' => app()->getLocale(), 'plan' => $plan]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <div class="modal fade" id="delete_{{$plan->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="card-body" style="padding:15px!important;">
                                                            <div>
                                                                <h4>Plan sil</h4>
                                                                <br>
                                                                <p> <span style="font-weight: bold">{{$plan->name}}</span> Plan silmek istediğinizden emin misiniz?</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="background-color: #eeeff6">
                                                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">
                                                            {{ __('theme/settings.close') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary"  style="color: white">
                                                            Plan sil
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @if($plan->plan_name !='Özel Plan')
                                    <button  class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_{{$plan->id}}">Plan Sil</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="new-plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yeni Plan Ekle</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" id="successful-message" role="alert" style="display: none">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        Yeni plan eklendi
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">PLAN Adı</label>
                            <input type="text" class="form-control" id="plan-name">
                        </div>
                        <div id="response">

                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">TEST LİMİTİ</label>
                            <input type="number" class="form-control" id="test-limit">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">ANAHTAR KELİME LİMİTİ</label>
                            <input type="number" class="form-control" id="keyword-limit">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary btn-submit">Yeni plan ekle</button>
                </div>
            </div>
        </div>
    </div>
@endsection
