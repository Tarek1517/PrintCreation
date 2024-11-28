import{r as u,o as h,c as r,b as i,e as l,t as U,w as m,v as c,H as p,F as k,g as f,a as n,f as S,J as C}from"./app-BHs_qdqJ.js";import{u as R}from"./useAxios-CvYkLGhC.js";import{i as I}from"./index-DF90ylPP.js";const L={class:"p-4 shadow max-w-3xl mx-auto"},N={class:"text-base mb-5"},V={class:"flex flex-col gap-5"},T={class:"w-full"},j={class:"w-full flex gap-5"},B={class:"w-full"},$={for:"slider-image",class:"border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-72 cursor-pointer"},A=["src"],D={key:1,class:"flex flex-col items-center justify-center gap-2"},J={__name:"Edit",setup(E){const v=S(),b=C(),{loadin:F,error:H,sendRequest:d}=R(),g=async()=>{const s=await d({method:"get",url:`/v1/slider/${b.params.id}`,headers:{"Content-Type":"multipart/form-data"}});t.value.id=s.data.id,t.value.url=s.data.url,t.value.order_number=s.data.order_number,o.value=s.data.image},o=u(null),x=s=>{const e=s.target.files[0];t.value.image=e,o.value=URL.createObjectURL(e)},t=u({id:null,url:null,image:null,order_number:null}),_=async s=>{await d({url:`/v1/slider/${s}`,method:"post",data:t.value,headers:{"Content-Type":"multipart/form-data"},params:{_method:"PUT"}})&&(I.success("Slider Updated Successfully"),v.push("/slider"))};return h(()=>{g()}),(s,e)=>{const y=f("Loading"),w=f("Icon");return n(),r(k,null,[i(y,{value:s.loading},null,8,["value"]),l("div",L,[l("h3",N,"Add New Home Slider "+U(t.value.status),1),l("div",V,[l("div",T,[e[3]||(e[3]=l("label",{for:"url",class:"text-sm block mb-1"},"URL",-1)),m(l("input",{type:"text",class:"p-2 rounded-md border w-full","onUpdate:modelValue":e[0]||(e[0]=a=>t.value.url=a)},null,512),[[c,t.value.url]])]),l("div",j,[l("div",null,[e[4]||(e[4]=l("label",{for:"url",class:"text-sm block mb-1"},"Order Number",-1)),m(l("input",{type:"number",class:"p-2 rounded-md border w-full","onUpdate:modelValue":e[1]||(e[1]=a=>t.value.order_number=a)},null,512),[[c,t.value.order_number]])])]),l("div",B,[e[6]||(e[6]=l("label",{for:"slider-image",class:"text-sm block mb-2"},"Slider Image",-1)),l("label",$,[o.value?(n(),r("img",{key:0,src:o.value,class:"w-full h-full rounded-md"},null,8,A)):p("",!0),o.value?p("",!0):(n(),r("div",D,[i(w,{name:"tabler:cloud-upload",class:"text-common text-5xl opacity-85"}),e[5]||(e[5]=l("span",{class:"text-common font-semibold opacity-85"},"Upload Slider Image",-1))])),l("input",{id:"slider-image",onChange:x,type:"file",hidden:""},null,32)])]),l("div",null,[l("button",{onClick:e[2]||(e[2]=a=>_(t.value.id)),class:"bg-common text-center w-full py-2 rounded"},"Update Slider")])])])],64)}}};export{J as default};