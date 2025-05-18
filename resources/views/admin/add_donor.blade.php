
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


  <form action="{{ url('upload_donor') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="padding:15px;">
        <label>Nome</label>
        <input type="text" name="name" required>
    </div>

    <div style="padding:15px;">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div style="padding:15px;">
        <label>Telefone</label>
        <input type="text" name="phone" required placeholder="(11) 91234-5678">
    </div>

    <div style="padding:15px;">
        <label>Endereço</label>
        <input type="text" name="address" required>
    </div>

    <div style="padding:15px;">
    <label>Tipo Sanguíneo</label>
    <select name="blood_type" required>
        <option value="">Selecione...</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
</div>

    <div style="padding:15px;">
        <label>Imagem</label>
        <input type="file" name="image">
    </div>

    <div style="padding:15px;">
        <input type="submit" class="btn btn-success" value="Cadastrar doador">
    </div>
  </form>     
 <!-- plugins:js -->
@include('admin.script')
<!-- End custom js for this page -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(document).ready(function(){
    $('input[name="phone"]').mask('(00) 00000-0000');
  });
</script>

  </body>
</html>