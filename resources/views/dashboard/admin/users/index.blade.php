@extends('layouts.dashboard.app')
@section('page-header', 'KULLANICILAR')
@section('js')
    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'inline';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        var language = '{{ app()->getLocale() }}';

        function change_plan(plan,user_id)
        {
            $('#plan_'+user_id).modal('show');

            $( "#submit_"+user_id ).click(function() {
                $.ajax({
                    url: "{{ route('user.plan-update', ['language' => app()->getLocale()]) }}",
                    type: 'POST',
                    data: {user_id:user_id,plan:plan },
                    success:function(){
                        location.reload();
                    },
                    error:function (){
                        alert("plan değişmedi");
                    }
                });
            });
        }

        $('.update').editable({
            url: "{{ route('user.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'limit',
            title: 'Test Limit',
            success: function(response, newValue) {
                location.reload();
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("Girilen değer 0'dan büyük olmalıdır.")
            }
        });

        $('.keyword-limit-update').editable({
            url: "{{ route('user.keywordLimit', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'keyword-limit-update',
            title: 'Keyword Limit',
            success: function(response, newValue) {
                location.reload();
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                alert("Girilen değer 0'dan büyük olmalıdır.")
            }
        });

        $('.landscape-test-limit').editable({
            url: "{{ route('user.landscape-limit', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'landscape_limit',
            title: 'landscape test limit',
            success: function(response, newValue) {
                location.reload();
                if(response.status == 'error') alert("Geçersiz değer");
            },
            error: function(response) {
                console.log(response);
                alert("Girilen değer 0'dan büyük olmalıdır.")
            }
        });
    </script>
@endsection
@section('content')
    <section>
        <div class="card card-table mb-4">
            <div class="card-header">
                <h5 class="card-heading"> KULLANICILAR</h5>
                <div class="card-header-more">
                    <button class="btn-header-more" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu dropdown-menu-end text-sm"><a class="dropdown-item" href="#!"><i class="fas fa-expand-arrows-alt opacity-5 me-2"></i>Expand</a><a class="dropdown-item" href="#!"><i class="far fa-window-minimize opacity-5 me-2"></i>Minimize</a><a class="dropdown-item" href="#!"><i class="fas fa-redo opacity-5 me-2"></i> Reload</a><a class="dropdown-item" href="#!"><i class="far fa-trash-alt opacity-5 me-2"></i> Remove        </a></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="text-align: center;font-size: 14px">
                        <thead>
                        <tr>
                            <th>SIRA</th>
                            <th>İSİM</th>
                            <th>EMAİL</th>
                            <th>TEST LİMİTİ</th>
                            <th>ALAN TARAMASI LİMİTİ</th>
                            <th>ANAHTAR KELİME LİMİTİ</th>
                            <th>ŞEKİL İLE ARAMA LİMİTİ</th>
                            <th>SOK AKTİFLİK</th>
                            <th>Plan</th>
                            <th>RAPORLAR</th>
                            <th>KAYIT TARİHİ</th>
                            <th colspan=2>İŞLEMLER</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($users as $key=>$user)
                            <tr class="align-middle">
                                <td>#{{$key+1}}</td>
                                <td>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td><a href="" class="update" data-name="limit" data-type="text" data-pk="{{ $user->id }}" data-title="Test Limit">{{ $user->search_limit }}</a></td>
                                <td><a href="" class="landscape-test-limit" data-name="landscape_limit" data-type="text" data-pk="{{ $user->id }}" data-title="landscape test limit">{{ $user->landscape_limit }}</a></td>
                                <td><a href="" class="keyword-limit-update" data-name="limit" data-type="text" data-pk="{{ $user->id }}" data-title="Keyword Limit">{{ $user->keyword_limit }}</a></td>
                                <td><a href="" class="keyword-limit-update" data-name="limit" data-type="text" data-pk="{{ $user->id }}" data-title="Keyword Limit">{{ $user->remaining_image_search }}</a></td>
                                <td>{{ $user->userActivities->last()->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <select id="planselect" class="form-select" onchange="change_plan(this.value,'{{$user->id}}')">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ ( $plan->id == $user->plan_id) ? 'selected' : '' }}> {{ $plan->plan_name }} </option>
                                        @endforeach
                                    </select>

                                    <div class="modal fade" id="plan_{{$user->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="card-body" style="padding:15px!important;">
                                                        <div>
                                                            <h4>Plan değiştirme</h4>
                                                            <br>
                                                            @foreach($plans as $plan)
                                                                @if($user->plan_id == $plan->id)
                                                                    <p> <span style="font-weight: bold">{{$plan->plan_name}}</span> değiştirmek istediğinizden emin misiniz? </p>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="background-color: #eeeff6">
                                                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">
                                                        {{ __('theme/settings.close') }}
                                                    </button>
                                                    <button id="submit_{{$user->id}}" type="submit" class="btn btn-primary"  style="color: white">
                                                        Yine de değiştir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->reports->count() }}</td>
                                <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                <td><a href="{{ route('user.show', ['language' => app()->getLocale(), 'user' => $user->id]) }}">Kullanıcı Detayları</a></td>
                                <td>
                                    <form action="{{ route('user.destroy', ['language' => app()->getLocale(), 'user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <div class="modal fade" id="delete_{{$user->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="card-body" style="padding:15px!important;">
                                                            <div>
                                                                <h4>Kullanıcıyı sil</h4>
                                                                <br>
                                                                <p> <span style="font-weight: bold">{{$user->name}}</span> kullanıcıyı silmek istediğinizden emin misiniz?</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="background-color: #eeeff6">
                                                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">
                                                            {{ __('theme/settings.close') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary"  style="color: white">
                                                            Kullanıcıyı sil
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button  class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_{{$user->id}}">Kullanıcıyı Sil</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
