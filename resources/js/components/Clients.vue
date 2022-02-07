<template>
    <div v-if="permissions.power != 'city'">

        <div class="card mb-3">

            <div class="card-header">
                <div class="row">
                    <div class="col-6"><h4>بيانات عامه</h4></div>
                    <div class="col-6 text-right">
                        <button class="btn btn-success" :disabled="insert == false || form.state == '' || form.gender == '' || form.age == '' || form.section == '' || form.amount == ''" @click="!editMode ? createData() : updateData()"><i class="fa fa-save"></i></button>
                        <button class="btn btn-primary" :disabled="editModal == true || center == '' || form.date == ''" data-toggle="modal" @click="selectClient()" :data-target="'#' + modalTitle"><i class="fa fa-search"></i></button>
                        <button class="btn btn-danger" @click="form.reset(); center = ''; city = ''; unit = ''; editMode = false; insert = false;"><i class="fa fa-close"></i></button>


                        <div class="modal fade" :id="modalTitle" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">

                                <div class="modal-content">
                                        <div class="modal-header">
                                            <input v-model="search" @blur="selectClient" class="form-control">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body table-responsive p-0">
                                            <table id="table_id" class="table table-bordered table-hover">
                                                <thead>
                                                <tr class="text-center">
                                                    <th>رقم الإستماره</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(client, index) in clients.data" @click="editModal(client)">
                                                    <td>{{ client.number }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <pagination :limit="10" :data="clients" @pagination-change-page="getResults"></pagination>
                                        </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <input type="month" id="date" v-model="form.date" class="form-control">
                    </div>
                    <div class="col-3">
                        <select id="city" v-model="city" @change="getUnits()" class="form-control">
                            <option value="">إختر المحليه .......</option>
                            <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select id="unit" v-model="unit" :disabled="city == ''" @change="getCenter"
                                class="form-control">
                            <option value="">إختر الوحده الاداريه .......</option>
                            <option v-for="unit in units" :value="unit.id">{{ unit.name }}</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select id="center" :disabled="unit == ''" @change="selectCenter()" v-model="center"
                                class="form-control">
                            <option value="">إختر المركز .......</option>
                            <option v-for="center in centers" :value="center.id">{{ center.name }}</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-6">
                <div class="card" style="min-height: 100%">
                    <div class="card-header"><h4>بيانات الاستماره</h4></div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="number" class="col-sm-3 col-form-label">رقم الاستماره</label>
                            <div class="col-sm-9">
                                <input type="text" :disabled="center == '' || form.date == ''" @blur="check" class="form-control" v-model="form.number" id="number" placeholder="رقم الاستماره">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label">الولايه</label>
                            <div class="col-sm-9">
                                <select id="state" :disabled="insert == false" v-model="form.state" class="form-control">
                                    <option value="">إختر الولايه .......</option>
                                    <option v-for="state in states" :selected="state.id == 128" :value="state.id">{{ state.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="section" class="col-sm-3 col-form-label">القطاع</label>
                            <div class="col-sm-9">
                                <select id="section" :disabled="insert == false" v-model="form.section" class="form-control">
                                    <option value="">إختر القطاع .......</option>
                                    <option v-for="section in sections" :value="section.id">{{ section.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-sm-3 col-form-label">الفئه العمريه</label>
                            <div class="col-sm-9">
                                <select id="age" :disabled="insert == false" v-model="form.age" class="form-control">
                                    <option value="">إختر الفئه العمريه .......</option>
                                    <option v-for="age in ages" :value="age.id">{{ age.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-sm-3 col-form-label">النوع</label>
                            <div class="col-sm-9">
                                <select id="gender" :disabled="insert == false" v-model="form.gender" class="form-control">
                                    <option value="">إختر النوع .......</option>
                                    <option value="1">ذكر</option>
                                    <option value="2">انثى</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label">تكلفة الاستماره</label>
                            <div class="col-sm-9">
                                <input type="text" :disabled="insert == false" class="form-control" v-model="form.amount" id="amount" placeholder="تكلفة الاستماره">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card" style="min-height: 100%">
                    <div class="card-header"><h4>المخالفات</h4></div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <select v-model="violation" :disabled="insert == false" class="form-control">
                                    <option value="">إختر المخالفه ......</option>
                                    <option v-for="violation in violations" :value="violation.id">{{ violation.name }}</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" v-model="violationCost">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-block btn-primary" @click="addViolation" :disabled="violation == ''"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="text-center">
                                <th>المخالفه</th>
                                <th>التكلفه</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(violation, index) in form.violations">
                                <td>{{ violations[index].name }}</td>
                                <td>{{ violation }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- /.box -->

        <div class="row mb-3">
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a v-for="row in rows" v-if="row.id != 1 && row.id != 2 && row.id != 11"
                       class="list-group-item list-group-item-action" data-toggle="list" :href="'#list' + row.id"
                       role="tab" aria-controls="home">
                        {{ row.id + '/' + row.name }}
                    </a>
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content" id="nav-tabContent">
                    <div v-for="row in rows" v-if="row.id != 1 && row.id != 2 && row.id != 11"
                         class="tab-pane fade show" :id="'list' + row.id" role="tabpanel"
                         aria-labelledby="list-home-list">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th class="w-25">اختيار</th>
                                        <th>الاسم</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(field, index) in row.fields">
                                        <td class="w-25"><input type="checkbox" :id="'field' + field.id" :value="field.id" v-model="form.name">
                                        </td>
                                        <td><label :for="'field' + field.id">{{ field.name }}</label></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
            modalTitle: 'clients',
            routeName: 'client',
            title: 'العملاء',
            subtitle: 'عميل',
            search: '',
            rows: {},
            ages: {},
            cities: {},
            city: '',
            insert: false,
            states: {},
            units: {},
            centers: {},
            clients: {},
            center: '',
            unit: '',
            date: '',
            sections: {},
            violations: {},
            ids: {},
            violation: '',
            violationCost: '',
            form: new Form({
                id: '',
                number: '',
                date: '',
                state: 128,
                age: '',
                gender: '',
                section: '',
                center: this.center,
                amount: '',
                name: [],
                violations: {},
            })
        }
    },
    props: ['auth_id', 'permissions'],
    methods: {
        check() {
            if (this.editMode == true) {
                if (this.form.number != '') {
                    axios.get('api/' + this.routeName + '?check=check&date=' + this.form.date + '&center=' + this.form.center + '&number=' + this.form.number + '&editMode=true&id=' + this.form.id)
                        .then(response => {
                            console.log(response);
                            if (response.data == true) {
                                this.insert = true;
                            } else if(response.data == false) {
                                this.insert = false;
                                toast.fire({
                                    icon: "error",
                                    title: "رقم الاستماره مدخل لهذا المركز بهذا الشهر مسبقاً"
                                });
                            }
                        });
                }
            } else {
                if (this.form.number != '') {
                    axios.get('api/' + this.routeName + '?check=check&date=' + this.form.date + '&center=' + this.form.center + '&number=' + this.form.number + '&editMode=true')
                        .then(response => {
                            console.log(response);
                            if (response.data == true) {
                                this.insert = true;
                            } else if(response.data == false) {
                                this.insert = false;
                                toast.fire({
                                    icon: "error",
                                    title: "رقم الاستماره مدخل لهذا المركز بهذا الشهر مسبقاً"
                                });
                            }
                        });
                }
            }
        },
        addViolation() {
            this.ids[this.violation] = this.violationCost;
            this.form.violations[this.violation] = this.violationCost;
            this.violation = '';
            this.violationCost = '';
        },
        getResults(page = 1) {
            axios.get('api/' + this.routeName + '?page=' + page)
                .then(response => {
                    this.clients = response.data;
                });
        },
        searchResults() {
            if (this.searchClient != '') {
                axios.get('api/' + this.routeName + '?name=' + this.searchClient).then(({data}) => (this.rows = data));
            } else if (this.searchClient == '') {
                axios.get('api/' + this.routeName).then(({data}) => (this.rows = data));
            }
        },
        selectClient() {
            if (this.search == '') {
                axios.get('api/' + this.routeName + '?select=clients&date=' + this.form.date + '&center=' + this.form.center).then(({data}) => (this.clients = data));
            } else {
                axios.get('api/' + this.routeName + '?select=clients&date=' + this.form.date + '&center=' + this.form.center + '&search=' + this.search).then(({data}) => (this.clients = data));
            }
        },
        updateData() {
            this.date = this.form.date;
            this.$Progress.start();
            this.form.put('api/' + this.routeName + '/' + this.form.id).then(() => {
                // Fire.$emit('afterCreate');

                $("#" + this.modalTitle).modal('hide');
                // this.loadData();
                toast.fire({
                    icon: 'success',
                    title: 'تم التعديل بنجاح'
                });

                this.editMode = false;

                this.form.reset();
                this.form.center = this.center;
                this.form.date = this.date;
                this.form.state = 128;

                this.selectClient();

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
            this.insert = false;
            this.editMode = true;
            this.form.reset();
            $("#" + this.modalTitle).modal("hide");

            this.form.fill(row);
            this.check();
            for (var vio in this.form.violations) {
                this.ids[this.form.violations[vio].violation_id] = this.form.violations[vio].amount;
            }
            this.form.violations = this.ids;
            this.violationCost = '';
            axios.get('api/' + this.routeName + '/' + row.id).then(({data}) => (this.form.name = data));
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
            axios.get('api/' + this.routeName)
                .then(response => {
                    this.states = response.data.states;
                    this.rows = response.data.tables;
                    this.cities = response.data.cities;
                    this.sections = response.data.sections;
                    this.ages = response.data.ages;
                    this.violations = response.data.violations;
                });
        },
        getUnits() {
            if (this.city != '') {
                axios.get('api/city/' + this.city)
                    .then(response => {
                        this.units = response.data;
                        this.unit = '';
                        this.center = '';
                    });
            } else {
                this.unit = '';
                this.center = '';
            }
        },
        getCenter() {
            if (this.unit != '') {
                axios.get('api/unit/' + this.unit)
                    .then(response => {
                        this.centers = response.data;
                        this.center = '';
                    });
            } else {
                this.center = '';
            }

        },
        selectCenter() {
            this.form.center = this.center;
        },
        createData() {
            this.date = this.form.date;
            this.$Progress.start();
            this.form
                .post("api/" + this.routeName)
                .then(() => {
                    toast.fire({
                        icon: "success",
                        title: "تم الحفظ بنجاح"
                    });
                    this.form.reset();
                    this.form.center = this.center;
                    this.form.date = this.date;
                    this.form.state = 128;
                    this.selectClient();

                    this.$Progress.finish();
                })
                .catch(() => {
                    toast.fire({
                        icon: "error",
                        title: "لم يتم الحفظ"
                    });
                });
        }
    },
    created() {

        this.loadData();

    }
}
</script>
