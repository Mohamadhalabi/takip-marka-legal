@extends('layouts.dashboard.app')
@section('page-header', 'Articles')
@section('content')
    <section id="loadTable">
        <div class="card card-table mb-4">
            <?php if(Session::has('error')): ?>
            <div class="alert alert-danger" id="message_id">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                    <?php echo e(Session::get('error')); ?>
                    <?php
                    Session::forget('error');
                    ?>
            </div>
            <?php endif; ?>
            <div class="card-header">
                <a href="{{ route('articles.create', ['language' => app()->getLocale()]) }}" style="float:right" class="btn btn-primary">
                    Create New Article
                </a>
                <h5 class="card-heading"> Articles</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="text-align: center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>TITLE</th>
                            <th>LANGUAGE</th>
                            <th>IS PUBLISHED</th>
                            <th colspan=2>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($articles as $key=>$article)
                            <tr class="align-middle">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $article->title }}</td>
                                <td>{{ strtoupper($article->language) }}</td>
                                <td>{{ $article->is_published ? 'Published' : 'Not Published' }}</td>
                                <td><a href="{{ route('articles.edit', ['language' => app()->getLocale(),'article'=>$article->id ]) }}">
                                    Edit
                                </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
