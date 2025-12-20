@if ($message = Session::get('success'))
    <div class="alert" style="padding: 10px;background-color: #16ac2a;color: white;margin-bottom: 15px;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert" style="padding: 10px;background-color: #d0382d;color: white;margin-bottom: 15px;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert" style="padding: 10px;background-color: rgb(219, 183, 51);color: white;margin-bottom: 15px;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert" style="padding: 10px;background-color: rgb(49, 159, 218);color: white;margin-bottom: 15px;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert" style="padding: 10px;background-color: #ca3025;color: white;margin-bottom: 15px;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';" style="margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;">&times;</span>
        <strong>Please check the form below for errors</strong>
    </div>
@endif