<template>
    <div>

        <div class="card mb-3 report-setting">

            <div class="card-header">
                <div class="row">
                    <div class="col-6"><h4>بيانات عامه</h4></div>
                    <div class="col-6 text-right">
                        <button class="btn btn-primary" :disabled="Object.keys(rows).length != 0" @click="loadReport"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-success" @click="printReport"><i class="fa fa-print"></i>
                        </button>
                        <button class="btn btn-danger" @click="cancel"><i class="fa fa-close"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <select id="reportType" :disabled="Object.keys(rows).length != 0" v-model="form.reportType" class="form-control">
                            <option value="">إختر فترة التقرير .......</option>
                            <option value="month">الشهري</option>
                            <option value="quarterOne">الربع الاول</option>
                            <option value="quarterTwo">الربع الثاني</option>
                            <option value="halfOne">النصف الاول</option>
                            <option value="quarterThree">الربع الثالث</option>
                            <option value="quarterFour">الربع الرابع</option>
                            <option value="halfTwo">النصف الثاني</option>
                            <option value="year">السنوي</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <input v-if="form.reportType == 'month'" :disabled="Object.keys(rows).length != 0" type="month" class="form-control" v-model="form.date">

                        <select v-if="form.reportType != 'month'" :disabled="Object.keys(rows).length != 0" v-model="form.date" class="form-control">
                            <option value="">إختر السنه .................</option>
                            <option v-for="n in 2030" v-if="n >= 2020">{{ n }}</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <select v-model="form.type" class="form-control"
                                :disabled="form.reportOf == 'center' || form.reportOf == '' || Object.keys(rows).length != 0">
                            <option value="">إختر نوع المرفق .......</option>
                            <option v-for="type in types" :value="type.id">{{ type.name }}</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <select v-model="form.category" class="form-control"
                                :disabled="form.reportOf == 'center' || form.reportOf == '' || Object.keys(rows).length != 0">
                            <option value="">إختر تصنيف المرفق .......</option>
                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-3">
                        <select v-model="form.reportOf" :disabled="Object.keys(rows).length != 0" class="form-control">
                            <option value="">إختر التقرير .......</option>
                            <option value="center">مركز</option>
                            <option value="unit">الوحده</option>
                            <option value="city">المحليه</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <select id="city" v-model="form.city"
                                :disabled="Object.keys(rows).length != 0 || permissions.power == 'city'"
                                @change="getUnits()" class="form-control">
                            <option value="">إختر المحليه .......</option>
                            <option v-if="form.reportOf == 'city'" value="all">الولايه</option>
                            <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <select id="unit" v-model="form.unit"
                                        :disabled="form.city == '' || form.reportOf != 'unit' && form.reportOf != 'center' || Object.keys(rows).length != 0"
                                        @change="getCenter"
                                        class="form-control">
                                    <option value="">إختر الوحده الاداريه .......</option>
                                    <option v-for="unit in units" :value="unit.id">{{ unit.name }}</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select id="center"
                                        :disabled="form.unit == '' || form.reportOf != 'center' || Object.keys(rows).length != 0"
                                        v-model="form.center"
                                        class="form-control">
                                    <option value="">إختر المركز .......</option>
                                    <option v-for="center in centers" :value="center.id">{{ center.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row mb-3" v-if="Object.keys(rows).length != 0">
            <div class="col-10 offset-1">
                <div class="card report">

                    <div class="card-body">

                        <div class="row report-header mb-2">
                            <div class="col-2 text-center"><img src="../favicon.png" alt=""></div>
                            <div class="col-8 text-center">
                                <h6>الصندوق القومي للتأمين الصحي</h6>
                                <h6>نظام إدارة الجوده</h6>
                                <h6>إدارة الخدمات الصحيه</h6>
                                <h6>قسم المطالبات</h6>
                                <h6 v-if="form.reportType == 'month'"><span>تقرير شهر</span> <span>{{ form.date }}</span></h6>
                                <h6 v-if="form.reportType != 'month'"><span>تقرير</span> <span>{{ reportHeader[form.reportType] }}</span> <span>للعام </span> <span>{{ form.date }}</span></h6>
                                <h6 v-if="form.reportOf == 'city' && Object.keys(cities).length != 0"><span v-if="form.city != 'all'">محلية {{ cities[form.city].name}}</span><span v-if="form.city == 'all'">الولايه الشماليه</span></h6>
                                <h6 v-if="form.reportOf == 'unit' || form.reportOf == 'center'"><span>وحدة </span><span>{{ units[form.unit].name}}</span></h6>
                                <h6 v-if="form.reportOf == 'center' && Object.keys(centers).length != 0"><span>مركز </span><span>{{ centers[form.center].name}}</span></h6>
                            </div>
                            <div class="col-2 text-center"><img src="../favicon.png" alt=""></div>
                        </div>


                        <div class="table-responsive p-0 " v-if="form.city == 'all' && form.reportOf == 'city'">
                            <table class="table rtl table-bordered table-hover mb-3">
                                <thead>

                                <tr class="text-center">
                                    <th>المحليه</th>
                                    <th>التردد</th>
                                    <th>التكلفه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in citiesfreqs">
                                    <td>{{ index }}</td>
                                    <td>{{ item.freq }}</td>
                                    <td>{{ item.cost }}</td>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <th>{{ sumGender('citiesCount') }}</th>
                                    <th>{{ sumGender('citiesCost') }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="table-responsive p-0"
                             v-if="form.reportOf == 'unit' || form.reportOf == 'city'">
                            <table class="table rtl table-bordered table-hover mb-3">
                                <thead>

                                <tr class="text-center">
                                    <th>نوع المرفق</th>
                                    <th>التردد</th>
                                    <th>التكلفه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in total">
                                    <td>{{ index }}</td>
                                    <td>{{ item.freq }}</td>
                                    <td>{{ item.cost }}</td>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <th>{{ sumGender('totalCount') }}</th>
                                    <th>{{ sumGender('totalCost') }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive p-0"
                             v-if="form.reportOf == 'unit' || form.reportOf == 'city'">
                            <table class="table table-bordered rtl table-hover mb-3" v-for="(freq, index) in freqs">
                                <thead>
                                <tr>
                                    <th colspan="5">{{ index }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>المحليه</th>
                                    <th>الوحده</th>
                                    <th>المركز</th>
                                    <th>التردد</th>
                                    <th>التكلفه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="center in freqs[index]">
                                    <td>{{ cities[center.city].name }}</td>
                                    <td>{{ center.unit }}</td>
                                    <td>{{ center.name }}</td>
                                    <td>{{ center.freq }}</td>
                                    <td>{{ center.cost }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3">المجموع</th>
                                    <th>{{ sum(freqs[index], 'freq') }}</th>
                                    <th>{{ sum(freqs[index], 'cost') }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive p-0" v-for="row in tables">

                            <table class="table table-bordered rtl table-hover mb-3" v-if="row.id == 1">
                                <thead>
                                <tr>
                                    <th :colspan="Object.keys(row.fields).length + 2">{{ row.id + '/' + row.name }}</th>
                                </tr>
                                <tr>
                                    <th rowspan="2">البيان</th>
                                    <th :colspan="Object.keys(row.fields).length">الفئات العمريه</th>
                                    <th rowspan="2">المجموع</th>
                                </tr>
                                <tr>
                                    <th v-for="field in row.fields">{{ field.name }}</th>
                                </tr>
                                </thead>

                                <tr>
                                    <th>ذكور</th>
                                    <td v-for="field in row.fields">{{ ages[field.id].males }}</td>
                                    <th>{{ sumGender('males') }}</th>
                                </tr>
                                <tr>
                                    <th>اناث</th>
                                    <td v-for="field in row.fields">{{ ages[field.id].females }}</td>
                                    <th>{{ sumGender('females') }}</th>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <td v-for="field in row.fields">{{ ages[field.id].males + ages[field.id].females }}</td>
                                    <th>{{ sumGender('males') + sumGender('females') }}</th>
                                </tr>
                                <tbody>
                                </tbody>
                            </table>

                            <table class="table table-bordered rtl table-hover mb-3" v-if="row.id == 11">
                                <thead>
                                <tr>
                                    <th colspan="3">{{ row.id + '/' + row.name }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>البيان</th>
                                    <th>التردد</th>
                                    <th>التكلفه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(field, index) in row.fields" v-if="field.name != 'الشماليه'">
                                    <td><label :for="'field' + field.id">{{ field.name }}</label></td>
                                    <td>{{ states[field.id].freq }}</td>
                                    <td>{{ states[field.id].cost }}</td>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <th>{{ sumGender('stateCount') }}</th>
                                    <th>{{ sumGender('stateCost') }}</th>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table rtl table-bordered table-hover mb-3"
                                   v-if="row.id == 2">
                                <thead>
                                <tr>
                                    <th colspan="3">{{ row.id + '/' + row.name }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>البيان</th>
                                    <th>التردد</th>
                                    <th>التكلفه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(field, index) in row.fields">
                                    <td><label :for="'field' + field.id">{{ field.name }}</label></td>
                                    <td>{{ sections[field.id].freq }}</td>
                                    <td>{{ sections[field.id].cost }}</td>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <th>{{ sumGender('sectionCount') }}</th>
                                    <th>{{ sumGender('sectionCost') }}</th>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table rtl table-bordered table-hover mb-3"
                                   v-if="row.id != 1 && row.id != 2 && row.id != 11">
                                <thead>
                                <tr>
                                    <th colspan="2">{{ row.id + '/' + row.name }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>البيان</th>
                                    <th>التردد</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(field, index) in row.fields">
                                    <td><label :for="'field' + field.id">{{ field.name }}</label></td>
                                    <td>{{ rows[field.id] }}</td>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <th>{{ sum(row, 'table') }}</th>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class=" table-responsive p-0">
                            <table class="table table-bordered table-hover mb-3">
                                <thead>
                                <tr class="text-center">
                                    <th colspan="3">المخالفات</th>
                                </tr>
                                <tr class="text-center">
                                    <th>المخالفه</th>
                                    <th>التردد</th>
                                    <th>التكلفه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in violationsFreq">
                                    <td>{{ index }}</td>
                                    <td>{{ item.freq }}</td>
                                    <td>{{ item.cost }}</td>
                                </tr>
                                <tr>
                                    <th>المجموع</th>
                                    <th>{{ sumGender('violationsCount') }}</th>
                                    <th>{{ sumGender('violationsCost') }}</th>
                                </tr>
                                </tbody>
                            </table>
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
            modalTitle: 'reports',
            routeName: 'report',
            title: 'التقارير',
            subtitle: 'تقرير',
            reportType: '',
            clients: {},
            cities: {},
            centers: {},
            units: {},
            tables: {},
            ages: {},
            sections: {},
            states: {},
            total: {},
            freqs: {},
            citiesfreqs: {},
            violationsFreq: {},
            types: {},
            categories: {},
            reportHeader: {
                quarterOne: 'الربع الأول',
                quarterTwo: 'الربع الثاني',
                halfOne: 'النصف الأول',
                quarterThree: 'الربع الثالث',
                quarterFour: 'الربع الرابع',
                halfTwo: 'النصف الثاني',
                year: 'السنوي',
            },
            unit: '',
            center: '',
            city: '',
            rows: {},
            form: new Form({
                id: '',
                date: '',
                reportType: '',
                reportOf: '',
                type: '',
                category: '',
                city: '',
                unit: '',
                center: '',
            })
        }
    },
    props: ['auth_id', 'permissions'],
    methods: {
        cancel() {
            this.form.reset();
            this.rows = {};
            if (this.permissions.power == 'city') {

                axios.get('api/user_Power?user=' + this.permissions.id)
                    .then(data => {
                        this.form.city = data.data.city_id;
                        this.getUnits();
                    });

            }
        },
        sum(table, name) {
            let sum = 0;
            if (name == 'table') {
                for (var row in table.fields) {
                    sum += this.rows[table.fields[row].id];
                }
            } else if (name == 'freq') {
                for (var row in table) {
                    sum += table[row].freq;
                }
            } else if (name == 'cost') {
                for (var row in table) {
                    sum += table[row].cost;
                }
            }
            return sum;
        },
        sumGender(name) {
            let sum = 0;
            if (name == 'males') {
                for (var row in this.ages) {
                    sum += this.ages[row].males;
                }
            } else if (name == 'females') {
                for (var row in this.ages) {
                    sum += this.ages[row].females;
                }
            } else if (name == 'sectionCount') {
                for (var row in this.sections) {
                    sum += this.sections[row].freq;
                }
            } else if (name == 'sectionCost') {
                for (var row in this.sections) {
                    sum += this.sections[row].cost;
                }
            } else if (name == 'stateCount') {
                for (var row in this.states) {
                    if (row != 128) {
                        sum += this.states[row].freq;
                    }
                }
            } else if (name == 'stateCost') {
                for (var row in this.states) {
                    if (row != 128) {
                        sum += this.states[row].cost;
                    }
                }
            } else if (name == 'totalCount') {
                for (var row in this.total) {
                    sum += this.total[row].freq;
                }
            } else if (name == 'totalCost') {
                for (var row in this.total) {
                    sum += this.total[row].cost;
                }
            } else if (name == 'citiesCost') {
                for (var row in this.citiesfreqs) {
                    sum += this.citiesfreqs[row].cost;
                }
            } else if (name == 'citiesCost') {
                for (var row in this.citiesfreqs) {
                    sum += this.citiesfreqs[row].freq;
                }
            } else if (name == 'violationsCount') {
                for (var row in this.violationsFreq) {
                    sum += this.violationsFreq[row].freq;
                }
            } else if (name == 'violationsCost') {
                for (var row in this.violationsFreq) {
                    sum += this.violationsFreq[row].cost;
                }
            }
            return sum;
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
            axios.get('api/' + this.routeName + '?select=clients').then(({data}) => (this.clients = data));
        },
        updateData() {
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
            this.editMode = true;
            this.form.reset();
            $("#" + this.modalTitle).modal("hide");

            this.form.fill(row);
            axios.get('api/' + this.routeName + '/' + row.id).then(({data}) => (this.form.name = data));
        },
        loadData() {
            axios.get('api/client')
                .then(response => {

                    this.cities = response.data.cities;
                    this.tables = response.data.tables;
                    this.types = response.data.types;
                    this.categories = response.data.categories;

                });
        },
        loadReport() {
            this.$Progress.start();
            this.form
                .post("api/" + this.routeName)
                .then((response) => {
                    this.rows = response.data.details;
                    this.ages = response.data.ages;
                    this.sections = response.data.sections;
                    this.states = response.data.states;
                    this.freqs = response.data.freqs;
                    this.total = response.data.total;
                    this.citiesfreqs = response.data.citiesfreqs;
                    this.violationsFreq = response.data.violationsFreq;
                    toast.fire({
                        icon: "success",
                        title: "تم جلب البيانات بنجاح"
                    });

                    this.$Progress.finish();
                })
                .catch(() => {
                    toast.fire({
                        icon: "error",
                        title: "لم يتم جلب البيانات"
                    });
                });
        },
        getUnits() {
            if (this.form.city != '' && this.form.city != 'all' && this.form.reportOf != 'city') {
                axios.get('api/city/' + this.form.city)
                    .then(response => {
                        this.units = response.data;
                        this.form.center = '';
                    });
            } else {
                this.form.unit = '';
                this.form.center = '';
            }
        },
        getCenter() {
            if (this.form.unit != '') {
                axios.get('api/unit/' + this.form.unit)
                    .then(response => {
                        this.centers = response.data;
                        this.center = '';
                    });
            } else {
                this.form.center = '';
            }

        },
        createData() {
            this.$Progress.start();
            this.form
                .post("api/" + this.routeName)
                .then(() => {
                    toast.fire({
                        icon: "success",
                        title: "تم الحفظ بنجاح"
                    });
                    this.form.reset();
                    this.selectClient();

                    this.$Progress.finish();
                })
                .catch(() => {
                    toast.fire({
                        icon: "error",
                        title: "لم يتم الحفظ"
                    });
                });
        },
        printReport() {
            window.print();
        }
    },
    created() {

        this.loadData();

        if (this.permissions.power == 'city') {

            axios.get('api/user_Power?user=' + this.permissions.id)
                .then(data => {
                    this.form.city = data.data.city_id;
                    this.getUnits();
                });

        }


    }
}
</script>
