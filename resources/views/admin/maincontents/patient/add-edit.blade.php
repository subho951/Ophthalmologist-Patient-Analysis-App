<?php
use App\Helpers\Helper;
$controllerRoute                = $module['controller_route'];
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="<?=url('admin/dashboard')?>">Dashboard</a> /</span>
    <span class="text-muted fw-light"><a href="<?=url('admin/' . $controllerRoute . '/list/')?>"><?=$module['title']?> List</a> /</span>
    <?=$page_header?>
  </h4>
  <div class="row">
    <?php
    if($row){
      $doctor_id              = $row->doctor_id;
      $name                   = $row->name;
      $email                  = $row->email;
      $phone                  = $row->phone;
      $dob                    = $row->dob;
      $pincode                = $row->pincode;
      $gender                 = $row->gender;
      $eye                    = $row->eye;
      $comorbidities_id       = $row->comorbidities_id;
      $status                 = $row->status;
      $countryId              = $row->country;
      $state                  = $row->state;
      $city                   = $row->city;
    } else {
      $doctor_id              = '';
      $name                   = '';
      $email                  = '';
      $phone                  = '';
      $dob                    = '';
      $pincode                = '';
      $gender                 = '';
      $eye                    = '';
      $comorbidities_id       = '';
      $status                 = '';
      $countryId              = '';
      $state                  = '';
      $city                   = '';
    }
    ?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <small class="text-danger">Star (*) marked fields are mandatory</small>
          <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="mb-3 col-md-6">
                 <label for="doctor_id" class="form-label">Doctor <small class="text-danger">*</small></label>
                 <select name="doctor_id" class="form-control" id="doctor_id" required>
                  <option value="" selected>Select Doctor</option>
                  <?php if($doctors){ foreach($doctors as $doctor){?>
                  <option value="<?=$doctor->id?>" <?=(($doctor->id == $doctor_id)?'selected':'')?>><?=$doctor->name?></option>
                  <?php } }?>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                 <label for="name" class="form-label">Name <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="name" name="name" value="<?=$name?>" required autofocus />
              </div>

              <div class="mb-3 col-md-6">
                 <label for="email" class="form-label">Email <small class="text-danger">*</small></label>
                 <input class="form-control" type="email" id="email" name="email" value="<?=$email?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                 <label for="phone" class="form-label">Phone <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="phone" name="phone" value="<?=$phone?>" required autofocus />
              </div>

              <div class="mb-3 col-md-6">
                 <label for="dob" class="form-label">DOB <small class="text-danger">*</small></label>
                 <input class="form-control" type="date" id="dob" name="dob" value="<?=$dob?>" required autofocus />
              </div>
              <div class="mb-3 col-md-6">
                <label for="country" class="form-label">Country <small class="text-danger">*</small></label>                  
                  <select name="country" class="form-control" id="country" required>
                      <option value="" selected>Select</option>
                      @if ($country)
                          @foreach ($country as $data)
                              <option value="{{ $data->id }}" @selected($data->id == $countryId)>
                                  {{ $data->name }}</option>
                          @endforeach
                      @endif
                  </select>                  
              </div>
              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">State <small class="text-danger">*</small></label>                                     
                  <select name="state" class="form-control" id="state" required>
                      <option value="" selected>Select State</option>
                  </select>                  
              </div>
              <div class="mb-3 col-md-6">
                  <label for="city" class="form-label">City <small class="text-danger">*</small></label>                  
                    <input type="text" name="city" class="form-control" id="city"
                        value="{{ old('city', $city ) }}" required>                  
              </div>
              <div class="mb-3 col-md-6">
                 <label for="pincode" class="form-label">Pincode <small class="text-danger">*</small></label>
                 <input class="form-control" type="text" id="pincode" name="pincode" value="<?=$pincode?>" required autofocus />
              </div>

              <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender <small class="text-danger">*</small></label>
                <select name="gender" class="form-control" id="gender" required>
                  <option value="" selected>Select Gender</option>
                  <option value="Male" <?=(($gender == 'Male')?'selected':'')?>>Male</option>
                  <option value="Female" <?=(($gender == 'Female')?'selected':'')?>>Female</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label for="eye" class="form-label">Eye <small class="text-danger">*</small></label>
                <select name="eye" class="form-control" id="eye" required>
                  <option value="" selected>Select Eye</option>
                  <option value="OD" <?=(($eye == 'OD')?'selected':'')?>>OD</option>
                  <option value="OS" <?=(($eye == 'OS')?'selected':'')?>>OS</option>
                </select>
              </div>

              <div class="mb-3 col-md-6">
                 <label for="comorbidities_id" class="form-label">Co-morbodities <small class="text-danger">*</small></label>
                 <select name="comorbidities_id" class="form-control" id="comorbidities_id" required>
                  <option value="" selected>Select Co-morbodities</option>
                  <?php if($comorbodities){ foreach($comorbodities as $comorbodity){?>
                  <option value="<?=$comorbodity->id?>" <?=(($comorbodity->id == $comorbidities_id)?'selected':'')?>><?=$comorbodity->name?></option>
                  <?php } }?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label d-block">Status <small class="text-danger">*</small></label>
                <div class="form-check form-switch mt-0 ">
                  <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" <?=(($status == 1)?'checked':'')?>>
                  <label class="form-check-label" for="status">Active</label>
                </div>
              </div>
           </div>
           <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2"><?=(($row)?'Save':'Add')?></button>
           </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#country').on('change', function () {
      // console.log("Country changed");
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: '{{ url("admin/get-states") }}/' + countryId,
                type: 'GET',
                success: function (data) {                                    
                    $.each(data.states, function (key, value) {
                        $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                  // ✅ Auto-select the first state (if any exist)
                  if (data.states.length > 0) {
                      $('#state').val(data.states[0].id);
                  }
                },
                error: function (xhr) {
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        } else {
            $('#state').empty().append('<option value="">Select State</option>');
        }
    });
  });
</script>