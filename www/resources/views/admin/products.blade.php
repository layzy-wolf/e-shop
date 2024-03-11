@extends("admin.layout")
@section("content")
    <main class="mx-5 my-5 w-100">
        <h2>
            Продукты
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
                    <th scope="col">img</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">category</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <th>{{$product->id}}</th>
                        <th><img src="{{Storage::URL($product->img)}}" alt="img" width="50" height="30">
                        </th>
                        <th>{{$product->name}}</th>
                        <th>{{$product->description}}</th>
                        <th>{{$product->category->name}}</th>
                        <th class="w-50">
                            <p>
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseForm{{$product->id}}" aria-expanded="false"
                                        aria-controls="collapseForm{{$product->id}}">
                                    Редактировать
                                </button>
                            </p>
                            <div class="collapse" id="collapseForm{{$product->id}}">
                                <div class="card card-body">
                                    <form action="{{route("admin.products.update", $product->id)}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method("patch")
                                        <div class="mb-3">
                                            <label for="name">Название</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{$product->name}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="replyNumber">Цена</label>
                                            <input type="number" class="form-control" id="replyNumber" name="price"
                                                   min="1" data-bind="value:replyNumber" placeholder="Цена"
                                                   value="{{$product->price}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category">Категория</label>
                                            <select class="form-select" id="category" name="category">
                                                <option value="">Нет</option>
                                                @foreach($categories as $item)
                                                    <option value="{{$item->id}}"
                                                            @if($item->id === $product->category->id) selected @endif>{{$item->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class=" mb-3">
                                                <label for=" description" class=" form-label">Описание</label>
                                                <textarea class=" form-control" id=" description" rows="3"
                                                          name="description"
                                                          required>{{$product->description}}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="file" class="form-label">Файл формата jpg</label>
                                                <input class="form-control" type="file" id="file" name="file">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Отправить</button>
                                        <a class="btn btn-danger"
                                           href="{{route("admin.products.delete", $product->id)}}">Удалить</a>
                                    </form>
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
        $("#add").bind("click", () => {
            if (fst) {
                $("<button />", {
                    class: "btn btn-primary w-100",
                    id: "send",
                    text: "Отправить"
                }).appendTo("#form-add")
                fst = false
                $("#send").bind("click", () => {
                    elems.forEach(async (el, i) => {
                        let formData = el.serializeArray()
                        formData = JSON.stringify({
                            name: formData[0].value,
                            price: formData[1].value,
                            category: formData[2].value,
                            description: formData[3].value,
                            img: await Base64(el.find("#file")[0].files[0])
                        })
                        $.ajax({
                            url: "{{route("admin.products.create")}}",
                            method: "post",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{csrf_token()}}"
                            },
                            data: formData,
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

        const form = id => {
            return '<form class="form-create" id="form-' + id + '" enctype="multipart/from-data">' +
                '<div class="input-group mb-3">' +
                '<input type="text" class="form-control" name="name" placeholder="Название" required>' +
                '<input type="number" class="form-control" id="replyNumber" name="price" min="1"' +
                'data-bind="value:replyNumber" placeholder="Цена" required>' +
                '<select class="form-select" data-bs-toggle=dropdown" aria-expanded=" false" name=" category_id" required>' +
                @foreach($categories as $category)
                    '<option value=" {{$category->id}}">{{$category->name}}</option>' +
                @endforeach
                    '</select>' +
                '</div>' +
                '<div class=" mb-3">' +
                '<label for=" description" class=" form-label">Описание</label>' +
                '<textarea class=" form-control" id=" description" rows="3" name="description" required></textarea>' +
                '</div>' +
                '<div class="mb-3">' +
                '<label for="file" class="form-label">Файл формата jpg</label>' +
                '<input class="form-control" type="file" id="file" name="file" required>' +
                '</div>' +
                '</form>'
        }

        const Base64 = file => new Promise((resolve, reject) => {
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = () => {
                    resolve(reader.result)
                }
                reader.onerror = reject
            }
        )
    </script>
@endsection
