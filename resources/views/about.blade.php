@extends('layouts.app')

@section('content')
  <div class="container text-center">
    <br>
    <h3>Tribunalul Specializat pentru Infractiuni de Coruptie</h3>
    <br>
    <table>
      <tr>
        <td class='bg-info bg-gradient' colspan='3'>Colegiu de conducere</td>
      </tr>
      <tr>
        <td>1</td>
        <td>Membru</td>
        <td>Judecator X</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Membru</td>
        <td>Judecator Y</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Membru</td>
        <td>Judecator Z</td>
      </tr>
    </table>
    <br>
    
    <div class="row">
      <div class="col-lg-4 mb-4 offset-lg-4">
        <div class="card border-primary rounded-0">
          <div class="card-header p-0">
            <div class="bg-primary text-white text-center py-2">
              <h3><i class="bi bi-chat mx-2"></i>Contact</h3>
            </div>
          </div>
          <div class="card-body p-3">
            <div class="form-group">
              <div class="input-group mb-2">
                <label class="mx-2 my-auto">Adresa</label>
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="bi bi-house text-info"></i></div>
                </div>
                <input type="text" class="form-control" value="Bucuresti, Romania" disabled>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-2">
                <label class="mx-2 my-auto">Email</label>
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="bi bi-envelope text-info"></i></div>
                </div>
                <input type="text" class="form-control" value="administrator@justitie.portal" disabled>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-2">
                <label class="mx-2 my-auto">Telefon</label>
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="bi bi-telephone text-info"></i></div>
                </div>
                <input type="text" class="form-control" value="0727849563" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

