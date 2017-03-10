<div style="margin: 0px 50px 0px 50px;">
    @if($portfolios)
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th>Name</th>
                <th>Filter</th>
                <th>Date of creation</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($portfolios as $k=>$portfolio)
                <tr>
                    <td>{{ $portfolio->id }}</td>
                    <td>{!! Html::link(route('portfolioEdit', ['portfolio'=>$portfolio->id]), $portfolio->name, ['alt'=>$portfolio->name]) !!} </td>
                    <td>{{ $portfolio->filter }}</td>
                    <td>{{ $portfolio->created_at }}</td>
                    <td>
                    {!! Form::open(['url'=>route('portfolioEdit', ['portfolio'=>$portfolio->id]), 'class'=>'form-horizontal', 'method'=>'POST']) !!}
                    {!! Form::hidden('_method', 'delete') !!} <!--подмена запроса-->
                        {!! Form::button('Delete', ['class'=>'btn btn-danger', 'type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    {!! Html::link(route('portfolioAdd'), 'New Portfolio') !!}
</div>