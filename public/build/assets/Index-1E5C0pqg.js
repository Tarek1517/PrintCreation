import{r as v,o as w,c as l,b as s,i as S,e,j as p,F as h,h as k,g as c,a as r,B as L,t as x}from"./app-BHs_qdqJ.js";import{u as j}from"./useAxios-CvYkLGhC.js";import{i as B}from"./index-DF90ylPP.js";const C={class:"shadow-lg rounded-lg text-sm"},R={class:"p-4"},N={class:"flex items-center justify-between"},A={class:"flex items-center gap-2"},D={class:"flex items-center justify-between"},I={class:"relative overflow-x-auto"},V={class:"w-full text-left rtl:text-right"},$={class:"hover:bg-secondary"},q={class:"px-6 py-4"},F=["src"],z={class:"px-6 py-4"},E={class:"flex items-center"},M=["href"],O={class:"px-6 py-4"},T={class:"px-6 py-4"},U={class:"flex items-center gap-2"},G=["onClick"],X={__name:"Index",setup(H){const{loading:f,error:J,sendRequest:d}=j(),i=v(null),u=async()=>{const n=await d({method:"get",url:"/v1/slider"});i.value=n.data},g=async n=>{await d({method:"delete",url:`/v1/slider/${n}`})&&(B.success("Slider Deleted Successfully",{autoClose:1e3}),u())};return w(()=>{u()}),(n,o)=>{var _;const b=c("Loading"),a=c("Icon"),m=c("RouterLink"),y=c("Search");return r(),l(h,null,[s(b,{value:S(f)},null,8,["value"]),e("section",C,[e("div",R,[e("div",N,[e("div",A,[s(a,{name:"solar:slider-minimalistic-horizontal-bold",class:"text-lg"}),o[0]||(o[0]=e("h3",{class:"text-base font-medium"},"Slider",-1))]),e("div",null,[s(m,{to:"/create-slider",class:"flex items-center gap-2 px-4 py-2 border border-common bg-common"},{default:p(()=>[s(a,{name:"material-symbols:add-box-outline"}),o[1]||(o[1]=L(" Add Record "))]),_:1})])]),e("div",D,[s(y)])]),e("div",I,[e("table",V,[o[2]||(o[2]=e("thead",{class:"uppercase bg-common"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3"}," Banner "),e("th",{scope:"col",class:"px-6 py-3"}," URL "),e("th",{scope:"col",class:"px-6 py-3"}," Order Number "),e("th",{scope:"col",class:"px-6 py-3"}," Action ")])],-1)),e("tbody",null,[(r(!0),l(h,null,k((_=i.value)==null?void 0:_.data,t=>(r(),l("tr",$,[e("td",q,[e("img",{src:t==null?void 0:t.image,class:"w-16 md:w-32 h-auto",alt:""},null,8,F)]),e("td",z,[e("div",E,[e("a",{href:t==null?void 0:t.url},x(t==null?void 0:t.url),9,M)])]),e("td",O,x(t==null?void 0:t.order_number),1),e("td",T,[e("div",U,[s(m,{to:`/edit-slider/${t==null?void 0:t.id}`,class:"w-8 h-8 rounded-md flex items-center justify-center bg-green-500 border border-green-900"},{default:p(()=>[s(a,{name:"material-symbols:edit-square-outline",class:"text-lg text-white"})]),_:2},1032,["to"]),e("button",{onClick:K=>g(t==null?void 0:t.id),class:"w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900"},[s(a,{name:"material-symbols:delete-outline",class:"text-lg text-white"})],8,G)])])]))),256))])])])])],64)}}};export{X as default};