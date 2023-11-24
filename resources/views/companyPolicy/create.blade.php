{{Form::open(array('url'=>'company-policy','method'=>'post', 'enctype' => "multipart/form-data"))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('branch',__('Branch'),['class'=>'form-label'])}}
                {{Form::select('branch',$branch,null,array('class'=>'form-control select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('title',__('Title'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'),['class'=>'form-label'])}}
                {{ Form::textarea('description',null, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-md-12">
            {{Form::label('attachment',__('Attachment'),['class'=>'form-label'])}}
            <div class="choose-file form-group">
                <label for="attachment" class="form-label">
                    <input type="file" class="form-control" name="attachment" id="attachment" data-filename="attachment_create">
                    <img id="image" class="mt-3" style="width:25%;"/>
                    <div id="pdficon">
                        <i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
                    </div>
                    <div id="wordicon">
                        <i class="fa fa-file-word-o" style="font-size:48px;color:red"></i>
                    </div>
                </label>
{{--                <p class="attachment_create"></p>--}}
            </div>
        </div>


    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


<script>
    $(document).ready(function() {        
        $('#pdficon').hide();
        $('#wordicon').hide();
    $('#attachment').change(function() {
      var fileName = $(this).val();
      var fileExtension = fileName.split('.').pop().toLowerCase();

      if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png') {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
        $('#image').show();
        $('#pdficon').hide();
        $('#wordicon').hide();
        console.log('File extension is valid: ' + fileExtension);
      } else if (fileExtension === 'pdf') {        
        $('#pdficon').show();
        $('#image').hide();
        $('#wordicon').hide();
        console.log('Invalid file extension: ' + fileExtension);
      } else if (fileExtension === 'docx') { 
        $('#wordicon').show();       
        $('#pdficon').hide();
        $('#image').hide();
        console.log('Invalid file extension: ' + fileExtension);
      } else{
        $('#image').hide();
        $('#pdficon').hide();
        $('#wordicon').hide();
      }
    });
  });
    // document.getElementById('document').onchange = function () {
    //     var src = URL.createObjectURL(this.files[0])
    //     document.getElementById('image').src = src
    // }
</script>