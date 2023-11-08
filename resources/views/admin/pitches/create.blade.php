@extends('admin.layout.master');
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Pitch</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

           

         
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              
              
            
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                   
                     @if(session('success'))
                        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                        <span class="badge badge-pill badge-success"></span>
                                          {{session('success')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                             @endif

                      @if($errors->any())
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger"></span>
                              <h4>{{$errors->first()}}</h4>
                            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button> -->
                        </div>
                    @endif

                      
                  <!-- /.tab-pane -->
                 

                  <div class="tab-pane" id="settings">
                  <form action="{{route('store-pitch')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                   @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Pitch Video</label>
                        <div class="col-sm-10">
                          <input type="file" name="url[]" accept="file_extension|audio/*|video/*|image/*|media_type" required="" class="form-control" multiple="">
                        </div>
                        <span class="text-danger">{{$errors->first('title')}}</span>

                      </div>
                      
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection

@section('script')


@endsection