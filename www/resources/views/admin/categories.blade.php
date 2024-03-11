@extends("admin.layout")
@section("content")
    <main class="mx-5 my-5 w-100">
        <h2>
            Категории
        </h2>
        <hr>
        <div class="d-flex flex-column gap-2" id="form-add">
            <button class="btn btn-primary w-100" id="add">Добавить</button>
        </div>
        <hr>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <th class="fw-medium">{{$category->name}}</th>
                        <th class="fw-medium">{{$category?->parent?->name}}</th>
                        <th class="w-50">
                            <p>
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseForm{{$category->id}}" aria-expanded="false"
                                        aria-controls="collapseForm{{$category->id}}">
                                    Редактировать
                                </button>
                            </p>
                            <div class="collapse" id="collapseForm{{$category->id}}">
                                <div class="card card-body">
                                    <form action="{{route("admin.categories.update", $category->id)}}" method="post">
                                        @csrf
                                        @method("patch")
                                        <div class="mb-3">
                                            <label for="name">Название</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{$category->name}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="category">Категория</label>
                                            <select class="form-select" id="category" name="category">
                                                <option value="">Нет</option>
                                                @foreach($categories as $item)
                                                    @if (!($item->id === $category->id))
                                                        <option value="{{$item->id}}"
                                                                @if(isset($category?->parent?->id) and $item->id === $category?->parent?->id) selected @endif>{{$item->name}}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Отправить</button>
                                        <a class="btn btn-danger" href="{{route("admin.categories.delete", $category->id)}}">Удалить</a>
                                    </form>
                                </div>
                            </div>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>

@endsection

@section("script")
    <script defer>
        let fst = true;
        let i = 0;
        let elems = [];
        const form = id => {
            return '<form class="form-create" id="form-' + id + '">' +
                '<div class="input-group mb-3">' +
                '<input type="text" class="form-control" name="name" aria-label="Ввод текста с помощью раскрывающейся кнопки">' +
                '<select class="form-select data-bs-toggle="dropdown" aria-expanded="false" name="category_id">' +
                '<option value="" selected>Категория</option>' +
                @foreach($categories as $category)
                    '<option value="{{$category->id}}">{{$category->name}}</option>' +
                @endforeach
                    '</select>' +
                '</div>' +
                '</form>'
        }
        $("#add").bind("click", () => {
            if (fst) {
                $("<button />", {
                    class: "btn btn-primary w-100",
                    id: "send",
                    text: "Отправить"
                }).appendTo("#form-add")
                fst = false
                $("#send").bind("click", () => {
                    elems.forEach((el, i) => {
                        let formData = el.serializeArray()
                        let jsonBody = JSON.stringify({
                            name: formData[0].value,
                            category_id: formData[1].value
                        })

                        $.ajax({
                            url: "{{route("admin.categories.create")}}",
                            method: "post",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{csrf_token()}}"
                            },
                            data: jsonBody,
                            success: () => {
                                if (i === elems.length - 1) {
                                    location.reload()
                                }
                            }
                        })
                    })
                })
            }
            $(form(i)).appendTo("#form-add")
            elems.push($("#form-" + i))
            i++
        })
    </script>
@endsection
