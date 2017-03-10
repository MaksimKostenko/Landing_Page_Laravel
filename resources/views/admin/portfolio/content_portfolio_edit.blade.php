<div class="wrapper container-fluid">
    {!! Form::open(['url'=>route('portfolioEdit', array('portfolio'=>$data['id'])), 'class'=>'form-horizontal', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}

    <div class="form-group">
        {!! Form::hidden('id', $data['id']) !!}
        {!! Form::label('name', 'Name:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('name', $data['name'], ['class'=>'form-control', 'placeholder'=>'Enter name of page']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('filter', 'Filter:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('filter', $data['filter'], ['class'=>'form-control', 'placeholder'=>'Enter filter of portfolio']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('old_images', 'Image:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-left">
            {!! Html::image('assets/img/'.$data['images'], '', ['class'=>'img-circle'])!!}
            {!! Form::hidden('old_images', $data['images']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('images', 'Image:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::file('images', ['class'=>'filestyle', 'data-buttonText'=>'Choose image', 'data-buttonName'=>'btn-primary', 'data-placeholder'=>'No file', 'data-icon'=>'false']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::button('Save', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}
        </div>
    </div>

    {!! Form::close() !!}

</div>