import{_ as o,a0 as n,a as m,c as r}from"./app-BHs_qdqJ.js";const s={"summernote.change":"summernoteChange","summernote.image.link.insert":"summernoteImageLinkInsert"};window.SUMMERNOTE_DEFAULT_CONFIGS||(window.SUMMERNOTE_DEFAULT_CONFIGS={});const i={props:{modelValue:{default:null,required:!0,event:"change",validator(e){return e===null||typeof e=="string"||e instanceof String}},config:{type:Object,default:()=>window.SUMMERNOTE_DEFAULT_CONFIGS}},data(){return{elem:null}},mounted(){this.elem=n(this.$refs.summernoteRefElement),this.elem.summernote(this.config),n(this.elem).on("summernote.change",this.onChange),this.modelValue&&n(this.elem).summernote("code",this.modelValue),this.registerEvents()},watch:{modelValue(e){const t=n(this.elem).summernote("code");e!=t&&n(this.elem).summernote("code",e)}},methods:{onChange(e){const t=n(this.elem).summernote("code");this.$emit("update:modelValue",t)},registerEvents(){for(var e in s)this.elem.on(`${e}`,(...t)=>{this.$emit(`${s[e]}`,...t)})}},beforeUnmount(){this.elem&&(this.elem.summernote("destroy"),this.elem=null)}},l={ref:"summernoteRefElement"};function u(e,t,a,c,h,d){return m(),r("div",l,null,512)}const _=o(i,[["render",u]]);export{_ as S};