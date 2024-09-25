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
    @if(session('error'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <div class="header">
        <h3>Total {{ $entityName }}: </h3>
        <div class="actions-container">
            <a href="{{ $createroute }}"><img src='{{ asset('assets/svgs/button-add.svg') }}' class="add-btn-icon"> Add {{ $entityName }}</a>
        </div>
    </div>

    @props([
        'entities', 
        'tableheadings', 
        'entityName', 
        'fields', 
        'createroute', 
        'editroute', 
        'deleteroute'
    ])
    
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                @foreach($tableheadings as $heading)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $heading }}
                    </th>
                @endforeach
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($entities as $entity)
                <tr>
                    @foreach($fields as $field)
                        <td class="px-6 py-4 whitespace-nowrap">{{ $entity->{$field} }}</td>
                    @endforeach
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route($editroute, $entity->InstructorID) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route($deleteroute, $entity->InstructorID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

    <!-- Use the pagination component -->
    <x-pagination :paginator="$entities" />
</div>