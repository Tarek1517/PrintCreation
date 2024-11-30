import{r as b,o as g,k as f,j as a,g as o,a as n,e,b as s,B as i,c as y,h,F as w}from"./app-BHs_qdqJ.js";import{u as _}from"./useAxios-CvYkLGhC.js";import"./index-DF90ylPP.js";const v={class:"px-4"},k={class:"bg-white p-4"},j={class:"flex items-center justify-between"},B={class:"flex items-center gap-3"},A={class:"flex items-center justify-between"},C={class:"flex items-center gap-3"},S={class:"mx-5 bg-white"},I={class:"relative overflow-x-auto"},L={class:"w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"},N={class:"bg-white border-b dark:bg-gray-800 dark:border-gray-700"},R={class:"px-6 py-4"},V={class:"flex items-center gap-2"},q={class:"w-8 h-8 rounded-md flex items-center justify-center bg-green-400/10 border border-green-900"},F={class:"w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900"},T={class:"w-8 h-8 rounded-md flex items-center justify-center bg-red-400/10 border border-red-900"},J={__name:"Index",setup(E){const{loading:M,error:Z,sendRequest:d}=_(),c=b(null),p=()=>{const l=d({method:"get",url:"/advertise"});c.value=l.data};return g(()=>{p()}),(l,t)=>{const r=o("Icon"),m=o("Button"),x=o("Select"),u=o("AppLayout");return n(),f(u,null,{default:a(()=>[e("section",v,[e("div",k,[e("div",j,[e("div",B,[s(r,{name:"ri:advertisement-fill",class:"text-3xl text-primary"}),t[0]||(t[0]=e("h3",{class:"text-primary text-3xl font-semibold"},"Advertise",-1))]),e("div",null,[s(m,{class:"flex items-center gap-2"},{default:a(()=>[s(r,{name:"material-symbols:add-box-outline"}),t[1]||(t[1]=i(" Add Record "))]),_:1})])]),e("div",A,[t[3]||(t[3]=e("div",{class:"flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900"},[e("label",{for:"table-search",class:"sr-only"},"Search"),e("div",{class:"relative"},[e("div",{class:"absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"},[e("svg",{class:"w-4 h-4 text-primary dark:text-gray-400","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 20 20"},[e("path",{stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"})])]),e("input",{type:"text",id:"table-search-users",class:"block p-2 ps-10 text-sm text-gray-900 border border-primary rounded-lg w-96 bg-gray-50 focus:ring-primary focus:border-primary",placeholder:"Search for Customers"})])],-1)),e("div",C,[t[2]||(t[2]=i(" Rows: ")),s(x,{class:"w-20",placeholder:"25",options:[5,10,15,20,25]})])])])]),e("div",S,[e("div",I,[e("table",L,[t[6]||(t[6]=e("thead",{class:"text-xs text-white uppercase bg-primary dark:bg-gray-700 dark:text-gray-400"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3"}," Banner "),e("th",{scope:"col",class:"px-6 py-3"}," Title "),e("th",{scope:"col",class:"px-6 py-3"}," Action ")])],-1)),e("tbody",null,[(n(),y(w,null,h(8,z=>e("tr",N,[t[4]||(t[4]=e("td",{class:"px-6 py-4"},[e("img",{src:"https://img.freepik.com/free-photo/woman-holding-various-shopping-bags-copy-space_23-2148674122.jpg?t=st=1719121783~exp=1719125383~hmac=a5500068561c90b563d99ed09fc0f960ed275f058c44b51067057a7bf59bdf66&w=826",class:"w-16 md:w-32 max-w-full max-h-full",alt:""})],-1)),t[5]||(t[5]=e("td",{class:"px-6 py-4"},[e("div",{class:"flex items-center"},[e("p",null,"woman holding various shopping")])],-1)),e("td",R,[e("div",V,[e("button",q,[s(r,{name:"material-symbols:visibility-outline-rounded",class:"text-xl text-green-900"})]),e("button",F,[s(r,{name:"material-symbols:edit-square-outline",class:"text-lg text-yellow-900"})]),e("button",T,[s(r,{name:"material-symbols:delete-outline",class:"text-lg text-red-900"})])])])])),64))])])])])]),_:1})}}};export{J as default};