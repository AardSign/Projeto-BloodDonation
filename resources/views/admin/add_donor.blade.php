
<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
    label
    {
        display: inline-block;
        width: 200px;
    }
    </style>

    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
    
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.navbar')
        <!-- partial -->

        <div class="container-fluid page-body-wrapper">

        
        
        <div class="container" align="center" style="padding-top:100px;">
        
        @if(session()->has('message'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            &times;
        </button>  
        {{ session()->get('message') }}
    </div>
@endif



        <form action="{{url('upload_donor')}}" method="POST" enctype="multipart/form-data">

        @csrf
        <div style="padding:15px;">
        <label>Nome do Doador </label>
        <input type="text" style="color:black" name="name" placeholder="Escreva seu nome" required> 
        </div> 

        <div style="padding:15px;">
        <label>Número de Telefone</label>
        <input type="text" style="color:black" name="number" placeholder="Escreva seu número" required>
        </div> 

        <div style="padding:15px;">
        <label>Cidade </label>
        <input type="text" style="color:black" name="place" placeholder="Escreva sua cidade" required>
        </div>

        <div style="padding:15px;">
        <label>Tipo Sanguíneo </label>
        <select name="blood_group" style="color:black; width:200px;" required>
        <option>Selecione</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <!-- <option>A Unknown</option> -->
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <!-- <option>B Unknown</option> -->
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <!-- <option>AB Unknown</option> -->
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <!-- <option>O Unknown</option>
        <option>Unknown</option> -->
        </select>     

        <div style="padding:15px;">
        <label>Foto de Perfil</label>
        <input type="file" name="file">
        </div>

        <div style="padding:15px;">
        
        <input type="submit" class="btn btn-success">
        </div>

        </div>

        </form>
        </div>


        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>