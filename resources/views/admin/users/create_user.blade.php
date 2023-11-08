@extends('admin.layout.master');
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <!-- <li class="breadcrumb-item active">User Profile</li> -->
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
                  <form action="{{route('store-user')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                   @csrf

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                          <input type="text" name="full_name" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('full_name')}}</span>

                      </div>


                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" name="email" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('email')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="password" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('password')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Avatar</label>
                        <div class="col-sm-10">
                          <input type="file" name="avatar" accept="file_extension|audio/*|video/*|image/*|media_type" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('title')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                          <input type="text" name="contact" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('contact')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <input type="text" name="address" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('address')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                          <input type="text" name="city" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('city')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">State</label>
                        <div class="col-sm-10">
                          <input type="text" name="state"  class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('state')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Zip Code</label>
                        <div class="col-sm-10">
                          <input type="number" name="zipcode" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('zipcode')}}</span>

                      </div>


                      <h3><b>Resume</b></h3>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                          <input type="text" name="resume_title" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('resume_title')}}</span>

                      </div>


                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                          <input type="text" name="resume_description" required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('resume_description')}}</span>

                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Upload Resume</label>
                        <div class="col-sm-10">
                          <input type="file" name="resume"  required="" class="form-control" >
                        </div>
                        <span class="text-danger">{{$errors->first('resume')}}</span>

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