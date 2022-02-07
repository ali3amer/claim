<template>
    <div>

        <div v-if="permissions.power == 'manger'" class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4"><h3 class="card-title">{{ title }}</h3></div>
                            <div class="col-6"><input type="text" placeholder="بحث ...." class="form-control"
                                                      v-model="search" @keyup="searchResults"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <select v-model="table" @change="loadData()" class="form-control">
                                        <option value="">إختر الجدول .......</option>
                                        <option v-for="item in tables" :value="item.id">{{ item.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-tools text-right">
                                    <button class="btn btn-primary" data-toggle="modal" @click="newModal()"
                                            :data-target="'#' + modalTitle"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body table-responsive p-0">
                <table id="table_id" class="table table-bordered table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>الرقم</th>
                        <th>الاسم</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in rows.data" :key="row.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.name }}</td>
                        <td>
                            <a href="#" :data-target="'#' + modalTitle" @click="editModal(row)"><i
                                class="fa fa-edit blue"></i></a> / <a href="#" @click="deleteData(row.id)"><i
                            class="fa fa-trash red"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <pagination :limit="5" :data="rows" @pagination-change-page="getResults"></pagination>

            </div>
        </div>
        <!-- /.box -->

        <div class="modal fade" :id="modalTitle" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateData() : createData()">
                        <div class="modal-header">
                            <h4 class="modal-title" style="display:inline-block" v-show="editMode" id="addNewLabel1">
                                تعديل بيانات {{ subtitle }}</h4>
                            <h4 class="modal-title" style="display:inline-block" v-show="!editMode" id="addNewLabel">
                                إضافة {{ subtitle }} جديد</h4>
                            <input class="form-control w-25 ml-2" @change="addRow" v-if="!editMode" type="number"
                                   v-model="num">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <select v-model="form.table_id" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('table_id') }">
                                    <option value="">إختر الجدول .......</option>
                                    <option v-for="item in tables" :value="item.id">{{ item.name }}</option>
                                </select>
                                <has-error :form="form" field="table_id"></has-error>
                            </div>

                            <div class="form-group" v-if="editMode">
                                <input v-model="form.name" type="text" placeholder="إسم الحقل"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            </div>

                            <div class="form-group" v-if="!editMode" v-for="(name, i) in form.name">
                                <input v-model="form.name[i]" @change="editName" type="text" placeholder="إسم الحقل"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" v-show="editMode" class="btn btn-success">تعديل</button>
                            <button type="submit" v-show="!editMode" class="btn btn-primary">إضافه</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: false,
            modalTitle: 'fields',
            routeName: 'field',
            title: 'الحقول',
            subtitle: 'الحقول',
            search: '',
            rows: {},
            tables: {},
            table: '',
            ids: {},
            num: 1,
            form: new Form({
                id: '',
                name: {},
                table_id: '',
            })
        }
    },
    props: ['auth_id', 'permissions'],
    methods: {
        editName() {
            this.table = 'dsadgf';
            this.table = '';
        },
        addRow() {
            this.form.name = {};
            this.ids = {};
            for (var i = 1; i <= this.num; i++) {
                this.form.name[i] = '';
            }

            let temps = Object.keys(this.form.name);

            for (var temp in temps) {
                this.ids[temps[temp]] = temps[temp];
            }
        },
        getResults(page = 1) {
            if (this.table == 0) {
                axios.get('api/' + this.routeName + '?page=' + page)
                    .then(response => {
                        this.rows = response.data;
                    });
            } else {
                axios.get('api/' + this.routeName + '?table=' + this.table + '&page=' + page)
                    .then(response => {
                        this.rows = response.data;
                    });
            }
        },
        searchResults() {
            if (this.search != '') {
                axios.get('api/' + this.routeName + '?name=' + this.search).then(({data}) => (this.rows = data));
            } else if (this.search == '') {
                axios.get('api/' + this.routeName).then(({data}) => (this.rows = data));
            }
        },
        updateData() {
            this.$Progress.start();
            this.form.put('api/' + this.routeName + '/' + this.form.id).then(() => {
                // Fire.$emit('afterCreate');

                $("#" + this.modalTitle).modal('hide');
                this.loadData();
                toast.fire({
                    icon: 'success',
                    title: 'تم التعديل بنجاح'
                });

                this.$Progress.finish();
            })
                .catch(() => {
                    toast.fire({
                        icon: "error",
                        title: "لم يتم التعديل"
                    });
                });
        },
        newModal() {
            this.editMode = false;
            this.form.reset();
            // $("#" + this.modalTitle).modal('show');
        },
        editModal(row) {
            this.editMode = true;
            this.form.reset();
            $("#" + this.modalTitle).modal('show');
            this.form.fill(row);
        },
        deleteData(id) {
            swal.fire({
                title: 'هل أنت متأكد أنك تريد الحذف',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم'
            }).then((result) => {
                this.$Progress.start();
                if (result.value) {
                    this.form.delete('api/' + this.routeName + '/' + id).then(() => {
                        this.loadData();
                        this.$Progress.finish();
                        toast.fire({
                            icon: 'success',
                            title: 'تم الحذف بنجاح'
                        });
                        // Fire.$emit('afterCreate');
                    }).catch(() => {
                        toast.fire({
                            icon: "error",
                            title: "لم يتم الحذف"
                        });
                    });

                }
            });
        },
        loadData() {
            if (this.table != 0) {
                axios.get('api/' + this.routeName + '?table=' + this.table).then(({data}) => (this.rows = data));
            } else {
                axios.get('api/' + this.routeName).then(({data}) => (this.rows = data));
            }
        },
        createData() {
            this.$Progress.start();
            $("#" + this.modalTitle).modal('hide');
            this.form
                .post("api/" + this.routeName)
                .then(() => {
                    // Fire.$emit("afterCreate");
                    $("#" + this.modalTitle).modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "تم الحفظ بنجاح"
                    });
                    this.loadData();
                    this.$Progress.finish();
                })
                .catch(() => {
                    toast.fire({
                        icon: "error",
                        title: "لم يتم الحفظ"
                    });
                });
        },
        // addRow() {
        //     this.form.name.push('');
        // }
    },
    created() {

        this.loadData();
        axios.get('api/table?select=all').then(({data}) => (this.tables = data));

        this.addRow();
    }
}
</script>
