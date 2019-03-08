<template>
    <div>
        <div class="border">
            <div class="p-3">
                <img class="w-100" :src="files[0] ? getPreview : getPlaceholder" alt="">
            </div>
            <div class="px-3 mb-3 d-flex justify-content-between" v-if="files.length > 0">
                <div class="d-flex align-items-center">
                    <label for="featured" class="switch mb-0">
                        <input type="checkbox" name="featured" id="featured"
                               :checked="featured === preview"
                               :disabled="preview === 0 && featured === 0"
                               @click="setFeatured">
                        <span class="slider round"></span>
                    </label>
                    <span class="mx-2">{{t('Featured')}}</span>
                </div>
                <div>
                    <div class="btn-cta mx-2" @click="changeCurrent">
                        <i class="ion ion-md-create i-lg"></i>
                    </div>
                    <div class="btn-cta" @click="remove">
                        <i class="ion ion-md-trash i-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex mt-3" :class="{'justify-content-between': files.length === 5}">
            <div v-for="(file, i) in files" :key="i">

                <span class="position-relative wh-50 d-block border"
                      :class="[{'ml-1': files.length < 5},{'border-dark': i === preview}]"
                      @click="preview = i">
                    <img class="img-fluid w-100" :src="file" alt="">
                </span>
            </div>
            <div class="form-group">
                <label for="product_image">
                    <span class="border position-relative wh-50 d-block" :class="{'ml-1': files.length < 5}">
                        <i class="ion ion-md-add position-absolute i-2x x-y-align"></i>
                    </span>
                    <input type="file" class="d-none" id="product_image" multiple
                           name="product_image"
                           ref="fileupload"
                           :disabled="files.length >= 5"
                           @change="onFileChanged">
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    import placeholder from '../assets/images/placeholder.png';

    export default {
        name: "imagesUpload",
        mixins: [],
        props: ['gallery'],
        data: function () {
            return {
                preview: 0,
                change: false,
                files: [],
                featured: 0,
            }
        },
        created() {
            if (this.gallery) {
                this.files = this.gallery.files;
                this.featured = this.gallery.featured;
            }
        },
        computed: {
            getPlaceholder() {
                return placeholder;
            },
            getPreview() {
                return this.files[this.preview];
            },
        },
        methods: {
            changeCurrent() {
                this.change = true;
                this.$refs.fileupload.click(true)
            },
            onFileChanged(e) {
                let fileTypes = ['jpg', 'jpeg', 'png'];

                /**
                 *  TODO: add multiple files functionality with html multiple and foreach limit to 5 files
                 */

                if (e.target.files && e.target.files[0]) {
                    let extension = e.target.files[0].name.split('.').pop().toLowerCase(),
                        isSuccess = fileTypes.indexOf(extension) > -1;

                    if (isSuccess) {
                        let reader = new FileReader();

                        reader.onload = (e) => {

                            if (!this.change) {
                                this.files.push(e.target.result);
                                this.preview = this.files.length - 1;
                            } else {
                                this.$set(this.files, this.preview, e.target.result);
                                this.change = false;
                            }

                        };
                        reader.readAsDataURL(e.target.files[0]);

                        const input = this.$refs.fileupload;
                        input.type = 'text';
                        input.type = 'file';

                        this.$emit('updateGallery', this.files, this.featured);

                    } else {
                        this.$parent.$emit('alert', 'error', this.t('File type is not allowed'));
                    }
                }
            },
            setFeatured(e) {
                if (e.target.checked) {
                    this.featured = this.preview;
                } else {
                    this.featured = 0
                }
                this.$emit('updateGallery', this.files, this.featured);
            },
            remove() {

                this.files.splice(this.preview, 1);

                if (this.featured === this.preview) {
                    this.featured = 0
                }else if(this.featured !== 0){
                    this.featured = this.featured - 1;
                }

                if (this.preview === this.files.length && this.preview !== 0) {
                    this.preview = this.preview - 1
                }

                this.$emit('updateGallery', this.files, this.featured);

            }
        },
    }


</script>


