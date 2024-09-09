<div class="content-wrapper">
    @if(session('success'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <div class="header">
        <h3>Total {{ $entityName }}: <span class="entity-count">{{ $entities->total() }}</span></h3>
        <div class="actions-container">
            <a href="{{ $createRoute }}"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add {{ $entityName }}</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>S.N</th>
                <th>{{ $column1 }}</th>
                <th>{{ $column2 }}</th>
                <th>{{ $column3 }}</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entities as $key => $entity)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $entity->{$field1} }}</td>
                    <td>{{ $entity->{$field2} }}</td>
                    <td>{{ $entity->{$field3} }}</td>
                    <td class="action-btn">
                        <a href="{{ route($editRoute, $entity->InstructorID) }}">
                            <img src="{{ asset('assets/svgs/edit.svg') }}" alt="Edit">
                        </a>
                        <form action="{{ route($deleteRoute, $entity->InstructorID) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this {{ strtolower($entityName) }}?');">
                                <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No {{ strtolower($entityName) }} found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Use the pagination component -->
    <x-pagination :paginator="$entities" />
</div>