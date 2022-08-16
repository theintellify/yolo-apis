<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

        


        <style>
            body {
                font-family: 'Nunito', sans-serif;

            }
           
        </style>
    </head>
    <body  style=" margin-bottom: 50px !important;">
         <div class="container-fluid">
          <h2>Create Custom API</h2>
          <div class="card mb-5">
            <div class="card-header">Add your API Type,URL,Body contents</div>
            <div class="card-body">
                      <form method="post" action="{{ route('store.customapi') }}">
                        @csrf
                      <div class="row col-md-12">
                          <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Select Type</label>
                                 <select name="api_type" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="GET">GET</option>
                                        <option value="POST">POST</option>
                                 </select>
                              </div>
                          </div>
                          <div class="col-md-10">
                              <div class="form-group">
                                <label for="exampleInputEmail1">API URL</label>
                                <input name="api_url" type="url" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter you api url" required="">
                                <small id="emailHelp" class="form-text text-muted"> </small>
                              </div>
                          </div>
                      </div>
                      <div class="row col-md-12">
                          <div class="col-md-12 form-group">
                            <label for="exampleInputEmail1">Enter Cognito ID</label>
                                <input name="cognitoid" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter you cognitoid" required="">
                                <small id="emailHelp" class="form-text text-muted"> </small>
                            
                          </div>
                      </div>
                      <div class="row col-md-12">
                          <div class="col-md-12 form-group">
                            <label for="exampleInputPassword1">Body</label>
                            <textarea name="request_body" class="form-control" rows="15" required="required">
                            </textarea>
                          </div>
                      </div>
                       <div class="row col-md-12">
                          <div class="col-md-12 form-group">
                            <button type="submit" class="btn btn-primary">Create</button>
                          </div>
                      </div>
                    </form>
            </div> 
            <div class="card-footer"></div>
          </div>
          
          <div class="col-lg-12">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 2%;">id</th>
                        <th style="width: 5%;">Type</th>
                        <th>URL</th>
                        <th>Request</th>
                        <th>Response</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($yoloApis))
                    @foreach($yoloApis as $key=>$api)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$api->api_type}}</td>
                        <td>{{$api->api_url}} </td>
                        <td><button type="button" data-toggle="modal" data-target="#request_body{{$key+1}}" class="btn btn-sm btn-primary">view</button>
                       <!-- Modal -->


                        </td>
                        <td>{{$api->response_data}}</td>
                        <div class="modal fade" id="request_body{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">API Request Body</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                {{$api->request_body}}
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>   
                        

                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>        

          </div>



        </div>
       <style type="text/css">
          #swagger-ui {
              margin-bottom: 50px !important;
            }
       </style>



        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

       <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>  
       <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>  
       <script >
        $(document).ready(function () {
            $('#example').DataTable();
        });
       </script>
    </body>
</html>
