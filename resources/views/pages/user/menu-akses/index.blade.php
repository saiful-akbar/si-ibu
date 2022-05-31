<x-layouts.auth title="Detail Menu Akses" back-button="{{ route('user') }}">
    <x-layouts.menu-akses :user="$user" :access="$userAccess">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">Table Akses User</h4>
                    </div>

                    <div class="card-body">
                        <x-table>
                            <x-slot name="thead">
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Read</th>
                                    <th class="text-center">Update</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($menuItems as $menuItem)
                                    <tr>
                                        <td>
                                            <i class="{{ $menuItem->icon }} mr-2"></i>
                                            {{ ucwords($menuItem->nama_menu) }}
                                        </td>
                                        <td class="text-center">
                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->create)
                                                <i class="mdi mdi-check text-success h4"></i>
                                            @else
                                                <i class="mdi mdi mdi-close text-danger h4"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->read)
                                                <i class="mdi mdi-check text-success h4"></i>
                                            @else
                                                <i class="mdi mdi mdi-close text-danger h4"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->update)
                                                <i class="mdi mdi-check text-success h4"></i>
                                            @else
                                                <i class="mdi mdi mdi-close text-danger h4"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->delete)
                                                <i class="mdi mdi-check text-success h4"></i>
                                            @else
                                                <i class="mdi mdi mdi-close text-danger h4"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.menu-akses>
</x-layouts.auth>
