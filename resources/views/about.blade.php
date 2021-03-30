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
      <div class="col-lg-4"></div>
      <div class="col-lg-4 mb-4">
        <div class="card border-primary rounded-0">
          <div class="card-header p-0">
            <div class="bg-primary text-white text-center py-2">
              <h3><i class="bi bi-house-door"></i>Contact</h3>
            </div>
          </div>
          <div class="card-body p-3">
              <div class="form-group">
                  <label>Adresa</label>
                  <div class="input-group">
                      <input type="text" class="form-control" value="Bucuresti, Romania" disabled>
                  </div>
              </div>
              <div class="form-group">
                  <label>Email</label>
                  <div class="input-group mb-2 mb-sm-0">
                      <input type="text" class="form-control" value="administrator@justitie.portal" disabled>
                  </div>
              </div>
              <div class="form-group">
                  <label>Telefon</label>
                  <div class="input-group mb-2 mb-sm-0">
                      <input type="text" class="form-control" value="0727849563" disabled>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4"></div>
    </div>

  </div>
@endsection

