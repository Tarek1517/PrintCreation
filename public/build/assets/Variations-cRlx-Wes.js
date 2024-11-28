import{r as l,o as P,q as T,c as _,b as o,i as q,e,B as x,F as S,h as F,j as v,g as f,a as b,t as g,w as A,v as M}from"./app-BHs_qdqJ.js";import{u as R}from"./useAxios-CvYkLGhC.js";import{_ as N}from"./Modal-C7JLu2cj.js";import{i as y}from"./index-DF90ylPP.js";const z={class:"bg-primary text-sm shadow-lg rounded-lg"},G={class:"p-4"},H={class:"flex items-center justify-between"},J={class:"flex items-center gap-2"},K={class:"flex items-center justify-between"},Q={class:"relative overflow-x-auto"},W={class:"w-full text-left rtl:text-right"},X={class:"hover:bg-secondary"},Y={class:"px-6 py-4"},Z={class:"px-6 py-4"},ee={class:"px-6 py-4"},te=["src"],se={class:"px-6 py-4"},ae={class:"px-6 py-4"},oe={class:"flex items-center gap-2"},le=["onClick"],ne=["onClick"],de={class:"flex flex-col gap-5 pt-5"},ie={class:"w-full"},re={class:"w-full"},ce={class:"flex flex-col gap-5 pt-5"},ue={class:"w-full"},pe={class:"w-full"},ge={__name:"Variations",setup(me){const{loading:$,error:ve,sendRequest:r}=R(),h=l(null),d=l({search:null,parPage:20}),i=async()=>{console.log(d==null?void 0:d.value);const a=await r({method:"get",url:"/v1/variation",data:d.value});h.value=a==null?void 0:a.data},w=l(null),c=l({name:null,image:null}),j=async()=>{var t;const a=await r({method:"post",url:"/v1/variation",data:c.value,headers:{"Content-type":"multipart/form-data"}});a!=null&&a.data&&(y.success(`${(t=a==null?void 0:a.data)==null?void 0:t.name} Variation Addded Succesfully`,{autoclose:1e3}),i(),u.value=!1)},n=l({id:null,name:null,image:null}),B=a=>{p.value=!0,n.value.id=a.id,n.value.name=a.name,w.value=a.image},O=async a=>{const t=await r({method:"post",url:`/v1/variation/${a}`,params:{_method:"PUT"},data:n.value,headers:{"Content-type":"multipart/form-data"}});t!=null&&t.data&&(y.success("Variatioin Updated Succesfully",{autoclose:1e3}),i(),p.value=!1)},U=async a=>{await r({method:"delete",url:`/v1/variation/${a}`,headers:{"Content-type":"multipart/form-data"}}),i(),y.success("Variation Deleted Succesfully",{autoClose:1e3})};P(()=>{i()});const u=l(!1),p=l(!1),I=()=>{u.value=!0},V=()=>{u.value=!1,p.value=!1,c.value.name=null,w.value=null};return T(d,i,{deep:!0}),(a,t)=>{var k;const D=f("Loading"),m=f("Icon"),E=f("Search"),C=f("Button");return b(),_(S,null,[o(D,{value:q($)},null,8,["value"]),e("section",z,[e("div",G,[e("div",H,[e("div",J,[o(m,{name:"simple-icons:nginxproxymanager",class:"text-lg"}),t[3]||(t[3]=e("h3",{class:"text-base font-me"},"Prodcut Variations",-1))]),e("div",null,[e("button",{class:"border border-common py-2 px-4 flex items-center gap-2 bg-common",onClick:I},[o(m,{name:"material-symbols:add-box-outline"}),t[4]||(t[4]=x(" Add Record "))])])]),e("div",K,[o(E)])]),e("div",null,[e("div",Q,[e("table",W,[t[6]||(t[6]=e("thead",{class:"uppercase bg-common"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3"}," Name "),e("th",{scope:"col",class:"px-6 py-3"}," Slug "),e("th",{scope:"col",class:"px-6 py-3"}," Image "),e("th",{scope:"col",class:"px-6 py-3"}," Created At "),e("th",{scope:"col",class:"px-6 py-3"}," Action ")])],-1)),e("tbody",null,[(b(!0),_(S,null,F((k=h.value)==null?void 0:k.data,s=>(b(),_("tr",X,[e("td",Y,g(s==null?void 0:s.name),1),e("td",Z,g(s==null?void 0:s.slug),1),e("td",ee,[e("img",{class:"w-20 h-auto object-cover",src:s==null?void 0:s.image},null,8,te)]),e("td",se,g(s==null?void 0:s.created_at),1),e("td",ae,[e("div",oe,[e("button",{onClick:L=>B(s),class:"w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900"},[o(m,{name:"material-symbols:edit-square-outline",class:"text-lg"})],8,le),t[5]||(t[5]=e("div",null,null,-1)),e("button",{onClick:L=>U(s==null?void 0:s.id),class:"w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900"},[o(m,{name:"material-symbols:delete-outline",class:"text-lg"})],8,ne)])])]))),256))])])])])]),o(N,{title:"Add New Attribute",isOpen:u.value,onModalClose:V},{default:v(()=>[e("div",de,[e("div",ie,[t[7]||(t[7]=e("label",{for:"name",class:"block text-sm mb-1"},"Variation Name",-1)),A(e("input",{"onUpdate:modelValue":t[0]||(t[0]=s=>c.value.name=s),type:"text",class:"p-2 border border-primary rounded-md w-full"},null,512),[[M,c.value.name]])]),e("div",re,[o(C,{onClick:j},{default:v(()=>t[8]||(t[8]=[x("Save Variations")])),_:1})])])]),_:1},8,["isOpen"]),o(N,{title:"Edit Attribute",isOpen:p.value,onModalClose:V},{default:v(()=>[e("div",ce,[e("div",ue,[t[9]||(t[9]=e("label",{for:"name",class:"block text-sm mb-1"},"Variation Name",-1)),A(e("input",{"onUpdate:modelValue":t[1]||(t[1]=s=>n.value.name=s),type:"text",class:"p-2 border border-primary rounded-md w-full"},null,512),[[M,n.value.name]])]),e("div",pe,[o(C,{onClick:t[2]||(t[2]=s=>O(n.value.id))},{default:v(()=>t[10]||(t[10]=[x("Update Variation")])),_:1})])])]),_:1},8,["isOpen"])],64)}}};export{ge as default};