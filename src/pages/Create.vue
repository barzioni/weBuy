<template>
    <div>
        <div class="d-flex align-items-center"
             :class="[step === 1 ? 'justify-content-end' : 'justify-content-between']">
            <button @click="prevStep" v-if="step > 1">{{t('Previous')}}</button>
            <button @click="nextStep" v-if="step < 3">{{t('Next')}}</button>
        </div>
        <form class="mt-3" @submit.prevent="create" autocomplete="off">

            <div v-if="step === 1">

                <div class="form-group">
                    <input type="text" class="form-control rounded-0" id="product_name" name="product_name"
                           v-model="formData.step_1.product_name">
                    <label for="product_name">{{t('Product name')}} *</label>
                </div>
                <div class="form-group">
                    <textarea class="form-control rounded-0" id="description" name="description" rows="5"
                              v-model="formData.step_1.description"></textarea>
                    <label for="description">{{t('Product name')}} *</label>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="number" class="form-control rounded-0" id="price" name="price"
                                   v-model="formData.step_1.price">
                            <label for="price">{{t('Product price')}} *</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="number" class="form-control rounded-0" id="max_participants"
                                   name="max_participants"
                                   v-model="formData.step_1.max_participants">
                            <label for="max_participants">{{t('Participants')}}*</label>
                        </div>
                    </div>
                </div>

                <div class="row align-items-start">
                    <div class="col-10">
                        <div class="form-group">
                            <input type="text" readonly class="form-control rounded-0" id="time_left" name="time_left"
                                   v-model="formData.step_1.time_left">
                            <label for="time_left">{{t('Time left')}}</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <date-picker @setTimeLeft="setTimeLeft"></date-picker>
                    </div>
                </div>
            </div>


            <div v-if="step === 2">
                <images-upload @updateGallery="setGallery" :gallery="formData.step_2"></images-upload>
            </div>

            <div v-if="step === 3">
                <div class="form-group">
                    <input type="text" class="form-control rounded-0" id="delivery_time" name="delivery_time"
                           v-model="formData.step_3.delivery_time">
                    <label for="delivery_time">{{t('Delivery time')}} *</label>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="payments">{{t('Payments')}} *</label>
                            <select id="payments" name="payments" class="form-control rounded-0"
                                    v-model="formData.step_3.payments">
                                <!--<option value="" disabled selected></option>-->
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="pickup">{{t('Pickup')}} *</label>
                            <select id="pickup" name="payments" class="form-control rounded-0"
                                    v-model="formData.step_3.pickup">
                                <!--<option value="" disabled selected></option>-->
                                <option value="option1">option 1</option>
                                <option value="option2">option 2</option>
                                <option value="option3">option 3</option>
                            </select>
                        </div>
                    </div>
                </div>


                <multiselect @onTagsChange="setTags" :label="t('Tags')"></multiselect>

                <div class="form-group">
                    <input type="text" class="form-control rounded-0" id="color" name="color"
                           v-model="formData.step_3.color">
                    <label for="color">{{t('Color')}}</label>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control rounded-0" id="warranty" name="warranty"
                           v-model="formData.step_3.warranty">
                    <label for="warranty">{{t('Warranty')}}</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-0" @click="nextStep">
                    {{t('Create')}}
                </button>
            </div>
        </form>

    </div>
</template>


<script>
    import validators from '../mixins/validators';
    import datePicker from '../components/datePicker';
    import imagesUpload from '../components/imagesUpload';
    import multiselect from '../components/multiselect';
    import axios from '../axios';
    // import router from '../router'

    export default {
        name: "create",
        mixins: [validators],
        components: {imagesUpload, multiselect, datePicker},
        data() {
            return {
                step: 1,
                formData: {
                    step_1: {
                        product_name: '',
                        description: '',
                        price: '',
                        time_left: '',
                        max_participants: '',
                    },
                    step_2: {
                        files: [],
                        featured: 0
                    },
                    step_3: {
                        delivery_time: '',
                        payments: '',
                        pickup: '',
                        tags: '',
                        color: '',
                        warranty: '',
                    }
                }
            }
        },
        methods: {
            create() {
            },
            setTimeLeft(e) {
                let today = new Date(e);
                let dd = today.getDate();
                let mm = today.getMonth() + 1;

                const yyyy = today.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }
                today = dd + '/' + mm + '/' + yyyy;
                this.formData.step_1.time_left = today;
            },
            setGallery(files, featured) {
                this.formData.step_2 = {
                    files: files,
                    featured: featured
                }
            },
            setTags(value) {
                this.formData.step_3.tags = value
            },
            prevStep() {
                this.step === 1 ? this.step = 1 : this.step--
            },
            nextStep() {
                let currStep = this.formData['step_' + this.step];
                let validStep = true;

                let excludes = ['tags', 'color', 'warranty'];

                for (let input in currStep) {
                    if (!excludes.includes(input)) {
                        if (currStep[input].length === 0) {
                            // this.$emit('alert', 'error', this.t("Please fill all the required fields"));
                            // validStep = false;
                        }
                    }
                }

                if (this.step < 3) {
                    if (validStep) {
                        this.step++
                    } else {
                        return false;
                    }
                } else {
                    if (validStep) {
                        this.sendFormData()
                    }
                }
            },
            sendFormData() {

                let form = [];
                for (let step in this.formData) {
                    for (let input in this.formData[step]) {
                        let obj = {};
                        obj[input] = this.formData[step][input];
                        form.push(obj)
                    }
                }

                console.log(form)

                axios.post('product/create', form,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(res => {
                    console.log('SUCCESS!!');
                })
                    .catch(err => {
                        console.log('FAILURE!!');
                    });

            }
        }
    };


</script>








