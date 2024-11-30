import{r as w,o as B,c as a,b as o,i as b,j as i,F as _,g as c,a as r,e,B as L,h as k,t as x}from"./app-BHs_qdqJ.js";import{u as j}from"./useAxios-CvYkLGhC.js";import{i as A}from"./index-DF90ylPP.js";const C={class:"bg-primary border border-slate-500 text-gray-300"},N={class:"p-4"},R={class:"flex items-center justify-between"},S={class:"flex items-center gap-3"},I={class:"flex items-center justify-between"},V={class:"relative overflow-x-auto"},$={class:"w-full text-sm text-left rtl:text-right"},q={class:"hover:bg-secondary"},D={class:"flex items-center px-6 py-4"},F=["src"],E={class:"px-6 py-4"},M=["src"],O={scope:"row",class:"px-6 py-4"},T={class:"text-base font-semibold"},z={class:"px-6 py-4"},G={class:"px-6 py-4"},H={class:"flex items-center gap-2"},J=["onClick"],Y={__name:"Index",setup(K){const{loading:h,error:P,sendRequest:d}=j(),u=w(null),m=async()=>{var s;const l=await d({method:"get",url:"/v1/brand"});u.value=(s=l==null?void 0:l.data)==null?void 0:s.data},f=async l=>{await d({method:"delete",url:`/v1/brand/${l}`})&&(await m(),A.success("Brand Deleted Successfully",{autoClose:1e3}))};return B(()=>{m()}),(l,s)=>{const y=c("Loading"),n=c("Icon"),p=c("RouterLink"),g=c("Search"),v=c("AppLayout");return r(),a(_,null,[o(y,{value:b(h)},null,8,["value"]),o(v,null,{default:i(()=>[e("section",C,[e("div",N,[e("div",R,[e("div",S,[o(n,{name:"tabler:brand-abstract"}),s[0]||(s[0]=e("h3",{class:"text-base font-medium"},"Brand",-1))]),e("div",null,[o(p,{to:"/create-brand",class:"flex items-center gap-2 border border-common text-common px-4 py-2"},{default:i(()=>[o(n,{name:"material-symbols:add-box-outline"}),s[1]||(s[1]=L(" Add Record "))]),_:1})])]),e("div",I,[o(g)])]),e("div",V,[e("table",$,[s[2]||(s[2]=e("thead",{class:"text-xs uppercase bg-secondary"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3"}," Logo "),e("th",{scope:"col",class:"px-6 py-3"}," Banner "),e("th",{scope:"col",class:"px-6 py-3"}," Name "),e("th",{scope:"col",class:"px-6 py-3"}," Order Number "),e("th",{scope:"col",class:"px-6 py-3"}," Action ")])],-1)),e("tbody",null,[(r(!0),a(_,null,k(u.value,t=>(r(),a("tr",q,[e("th",D,[e("img",{class:"h-16 w-16",src:t==null?void 0:t.logo},null,8,F)]),e("td",E,[e("img",{src:t==null?void 0:t.banner,class:"w-16 md:w-32 h-16 max-w-full max-h-full",alt:""},null,8,M)]),e("th",O,[e("div",null,[e("div",T,x(t==null?void 0:t.name),1)])]),e("td",z,x(t==null?void 0:t.order_number),1),e("td",G,[e("div",H,[o(p,{to:`/edit-brand/${t==null?void 0:t.id}`,class:"w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900"},{default:i(()=>[o(n,{name:"material-symbols:edit-square-outline",class:"text-lg text-white"})]),_:2},1032,["to"]),e("button",{onClick:Q=>f(t==null?void 0:t.id),class:"w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900"},[o(n,{name:"material-symbols:delete-outline",class:"text-lg text-white"})],8,J)])])]))),256))])])])])]),_:1})],64)}}};export{Y as default};