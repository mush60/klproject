@extends('backend.layout.main')

@section('pagecss')
    
@endsection

@section('pagetitle')
    Admin Dashboard | Form Add Champion
@endsection

@section('topnav')
    
@endsection

@section('usertopnav')
    
@endsection

@section('pagemenu')
    <li><a href="{{route('admin.list_peserta')}}"><i class="fa fa-fw fa-users"></i> Data Pendaftar</a></li>
    <li><a href="{{route('admin.add_peserta')}}"><i class="fa fa-fw fa-user-plus"></i> Tambah Peserta</a></li>
    <li><a href="{{route('admin.add_admin')}}"><i class="fa fa-fw fa-user-plus"></i> Tambah Admin</a></li>

    {{-- <li><a href="{{route('admin.add_peserta')}}"><i class="fa fa-fw fa-user-plus"></i> Tambah Peserta</a></li>
    <li><a href="{{route('admin.add_peserta')}}"><i class="fa fa-fw fa-user-plus"></i> Tambah Peserta</a></li>
    <li><a href="{{route('admin.add_peserta')}}"><i class="fa fa-fw fa-user-plus"></i> Tambah Peserta</a></li> --}}
@endsection

@section('pagebreadcrumb')
    Admin Dashboard | Form Add Champion
@endsection

@section('pagecontent')
<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Form Add Champion
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-xs-12 col-form-label">Grade</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control m-b grade" name="grade" id="grade" required>
                                        <option value=""> Pilih Grade </option>
                                    @foreach ($data_cat as $cat)
                                        <option value="{{$cat->grade}}" data-turl="{{route('admin.get_champion_cat', ['grade' => $cat->grade])}}">{{$cat->grade}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-xs-12 col-form-label">Kategori</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control m-b cat_id" name="cat_id" id="cat_id" required>
                                    <option value=""> Pilih Kategori </option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-xs-12 col-form-label">Owner</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control m-b owner" name="owner" id="owner" required>
                                        <option value=""> Pilih Owner </option>
                                    @foreach ($data_user as $user)
                                        <option value="{{$user->id}}" data-turl="{{route('admin.get_fish_champion', ['user_id' => $user->id])}}"> {{$user->bio->nama}} </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-xs-12 col-form-label">Ikan</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control m-b user_fish_id" name="user_fish_id" id="user_fish_id" required>
                                    <option value=""> Pilih Ikan </option>
                                    
                                </select>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="form-group row">
                    //
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <script>
    $(document).ready(function() {
        if($('#flash_data').length) {
            let type = $('#flash_data').data('type');
            let msg = $('#flash_data').data('msg');
        
            Swal.fire({
                icon: type,
                text: msg,
                showConfirmButton: true,
            });
        };

        $('.grade').on('change', function(){
            var grade = $('#grade').val();
            var turl = $(this).find(':selected').data('turl');
            if(grade != '') {
                $.ajax({
                    url : turl,
                    cache: false,
                    success: function(json) {
                        $("#cat_id").html('');
                        if(Object.keys(json).length > 0) {
                            for(i=0; i<Object.keys(json).length; i++) {
                                if(i==0) {
                                    $('#cat_id').append($('<option selected>').text(json[i].cat_name).attr('value', json[i].id));
                                } else {
                                    $('#cat_id').append($('<option>').text(json[i].cat_name).attr('value', json[i].id));
                                }
                            }
                        } else {
                            $('.cat_id').append($('<option>').text('Ikan Belum Lunas, Atau Ikan Belum Terdaftar').attr('value', ''));
                        }
                        // console.log($('#cat_id').val());
                    }
                });
            }
        });

        $('.owner').on('change', function(){
            var turl = $(this).find(':selected').data('turl');
            if(grade != '') {
                $.ajax({
                    url : turl,
                    cache: false,
                    success: function(json) {
                        $("#user_fish_id").html('');
                        if(Object.keys(json).length > 0) {
                            for(i=0; i<Object.keys(json).length; i++) {
                                if(i==0) {
                                    $('#user_fish_id').append($('<option selected>').text(json[i].fish.name).attr('value', json[i].id));
                                } else {
                                    $('#user_fish_id').append($('<option>').text(json[i].fish.name).attr('value', json[i].id));
                                }
                            }
                        } else {
                            $('.user_fish_id').append($('<option>').text('Tidak Ada Ikan Pada User Ini').attr('value', ''));
                        }
                        console.log(json);
                    }
                });
            }
        });
    });
    </script>
@endsection