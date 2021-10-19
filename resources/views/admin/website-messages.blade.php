@extends('admin.base')

@section('section_title')
    <strong>Website Messages</strong>
@endsection

@section('section_body')

    <div class="row">
        <div class="col-md-12">
            @if( empty( $name ) )
                    @else
                        <form method="POST" action="/admin/update_website-messages">
                            <input type="hidden" name="id" value="{{ $msgID }}">
                            @endif
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="msgName">Name</label>
                                    <input type="text" name="name" id="msgName" value="{{ $name }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="msgGet">Message</label>
                                    <input type="text" name="msg" id="msgGet" value="{{ $msg }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="msgGet">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" @if($status == 1) selected @endif>Enable</option>
                                        <option value="0" @if($status == 0) selected @endif>Disable</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <input type="submit" name="sb" value="Save Message" class="btn btn-primary">
                                </div>
                            </div>

                        </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->

    <br/>
    <hr/>

    @if($messages)
        <table class="table table-striped table-bordered table-responsive dataTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $messages as $m )
                <tr>
                    <td>
                        {{ $m->id }}
                    </td>
                    <td>
                        {{ $m->name }}
                    </td>
                    <td>
                        {{ $m->msg }}
                    </td>
                    <td>
                        @if($m->status == 1)
                            <span style="color:green;font-weight:bold;">Enabled</span>
                        @else
                            <span style="color:red;font-weight:bold;">Disabled</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary btn-xs" href="/admin/website-messages?update={{ $m->id }}">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            {{--<a href="/admin/categories?remove={{ $m->id }}" onclick="return confirm('Are you sure you want to remove this category from database?');" class="btn btn-danger btn-xs">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>--}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        No messages in database.
    @endif

@endsection