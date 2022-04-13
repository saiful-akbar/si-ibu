<x-layouts.auth title="Edit Menu Akses" back-button="{{ route('user') }}">
    <x-layouts.menu-akses :user="$user" :access="$userAccess">
        <div class="row">
            <div class="col-12 mb-3">
                <x-alert color="info" title="info" dismissible>
                    User akan dianggap sebagai admin pada menu jika memiliki full akses (create, read, update & delete).
                </x-alert>
            </div>
        </div>

        <x-form action="{{ route('user.menu-akses.update', ['user' => $user->id]) }}" method="PATCH">
            @foreach ($menuHeaders as $menuHeader)
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">

                                {{-- input menu header --}}
                                <div class="row">
                                    <div class="col-12 border-bottom mb-3">
                                        <input type="hidden" name="menuHeader[{{ $menuHeader->id }}][id]"
                                            value="{{ $menuHeader->id }}" />

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input name="menuHeader[{{ $menuHeader->id }}][read]"
                                                    id="header_{{ $menuHeader->id }}" type="checkbox"
                                                    class="custom-control-input form-control-lg menu-headers"
                                                    data-header="header_{{ $menuHeader->id }}"
                                                    @if (isset($user->menuHeader->find($menuHeader->id)->pivot) && $user->menuHeader->find($menuHeader->id)->pivot->read) checked @endif />

                                                <label class="custom-control-label" for="header_{{ $menuHeader->id }}">
                                                    {{ ucwords($menuHeader->nama_header) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End input header --}}

                                {{-- Input menu item --}}
                                @foreach ($menuHeader->menuItem as $menuItem)
                                    <div class="form-group row mb-3">
                                        <div class="col-md-4 col-sm-12 mb-1">
                                            <span class="h5">
                                                <i class="{{ $menuItem->icon }} mr-2"></i>
                                                <span>{{ $menuItem->nama_menu }}</span>
                                            </span>
                                        </div>

                                        {{-- input id --}}
                                        <input type="hidden"
                                            name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][id]"
                                            value="{{ $menuItem->id }}" />

                                        {{-- input create --}}
                                        <div class="col-md-2 col-sm-6 mb-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][create]"
                                                    class="custom-control-input header_{{ $menuHeader->id }}"
                                                    id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_create"
                                                    @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->create == 1) checked @endif
                                                    @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                <label class="custom-control-label"
                                                    for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_create">
                                                    Create
                                                </label>
                                            </div>
                                        </div>

                                        {{-- input read --}}
                                        <div class="col-md-2 col-sm-6 mb-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][read]"
                                                    class="custom-control-input header_{{ $menuHeader->id }}"
                                                    id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_read"
                                                    @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->read == 1) checked @endif
                                                    @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                <label class="custom-control-label"
                                                    for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_read">
                                                    Read
                                                </label>
                                            </div>
                                        </div>

                                        {{-- input update --}}
                                        <div class="col-md-2 col-sm-6 mb-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][update]"
                                                    class="custom-control-input header_{{ $menuHeader->id }}"
                                                    id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_update"
                                                    @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->update == 1) checked @endif
                                                    @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                <label class="custom-control-label"
                                                    for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_update">
                                                    Update
                                                </label>
                                            </div>
                                        </div>

                                        {{-- input delete --}}
                                        <div class="col-md-2 col-sm-6 mb-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][delete]"
                                                    class="custom-control-input header_{{ $menuHeader->id }}"
                                                    id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_delete"
                                                    @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->delete == 1) checked @endif
                                                    @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                <label class="custom-control-label"
                                                    for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}_delete">
                                                    Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- End input menu item --}}

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-info btn-sm mr-2">
                        <i class="mdi mdi-content-save"></i>
                        <span>Simpan</span>
                    </button>

                    <button type="reset" class="btn btn-dark btn-sm">
                        <i class="mdi mdi-close"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </x-form>
    </x-layouts.menu-akses>

    <x-slot name="script">
        <script src="{{ asset('assets/js/pages/user.js') }}"></script>
    </x-slot>
</x-layouts.auth>
