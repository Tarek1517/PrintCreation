import{r as d,q as es,o as xs,c as i,b as v,i as ys,j as ts,F as ls,g as p,a as o,e as s,B as as,t as a,k as ns,H as x,h as _s,J as ws}from"./app-BHs_qdqJ.js";import{u as bs}from"./useAxios-CvYkLGhC.js";import{i as os}from"./index-DF90ylPP.js";const gs={class:"flex items-center justify-between p-4 bg-primary text-gray-300 shadow-md"},hs={class:"text-red-600 font-medium"},Ss={class:"flex items-center gap-4"},js={class:"flex flex-wrap mt-5"},ks={class:"w-4/6"},Cs={class:"bg-primary text-gray-300 shadow-md mb-10"},Vs={class:"w-full text-sm text-left rtl:text-right text-black"},As={class:"text-gray-300"},Os={class:"py-1 px-6 flex items-center gap-4"},Ps=["src"],Ls={class:"px-6 py-1 font-semibold text-xs"},Bs={class:"px-6 py-1 font-semibold text-xs"},Ts={class:"px-6 py-1 font-semibold text-xs"},Ns={class:"w-full flex"},$s={class:"w-1/2 lg:pr-2"},Ds={class:"p-4 bg-primary mb-5 shadow-md text-gray-300"},Is={key:0,class:"flex flex-col gap-4"},Rs={class:"w-full flex items-center justify-between"},Us={class:"w-full flex items-center justify-between"},qs={class:"w-full flex items-center justify-between"},Es={class:"w-full flex items-center justify-between"},Fs={class:"w-full flex items-center justify-between"},Hs={class:"w-full flex items-center justify-between"},Gs={class:"w-1/2 lg:pr-2"},Js={class:"p-4 bg-primary mb-5 shadow-md text-gray-300"},Ms={class:"flex flex-col gap-4"},zs={class:"w-full flex items-center justify-between"},Qs={class:"w-full flex items-center justify-between"},Ws={class:"w-full flex items-center justify-between"},Ks={class:"w-full flex items-center justify-between"},Xs={class:"w-2/6 lg:pl-5"},Ys={class:"p-4 bg-primary text-gray-300 mb-5 shadow-md"},Zs={class:"flex flex-col gap-4"},se={class:"w-full flex items-center justify-between"},ee={class:"w-full flex items-center justify-between"},te={class:"w-full flex items-center justify-between"},le={class:"p-4 bg-primary text-gray-300 shadow-md"},ae={class:"w-full flex items-center justify-between"},ie={__name:"Show",setup(ne){const{loading:us,error:oe,sendRequest:c}=bs(),m=ws(),l=d(null),f=d(!1),rs=async()=>{const n=await c({method:"get",url:`/v1/order/${m.params.id}`});n&&(l.value=n.data,u.value.order_status=n.data.order_status,r.value.payment_status=n.data.payment_status)},ds=[{name:"pending"},{name:"received"},{name:"process"},{name:"shipped"},{name:"delivered"},{name:"cancel"}],is=[{name:"pending"},{name:"paid"},{name:"cancelled"}],u=d({order_status:null}),r=d({payment_status:null}),ps=async()=>{if(!f.value)return;await c({method:"post",url:`/v1/order/${m.params.id}`,data:u.value,params:{_method:"PATCH"}})&&os.success("Order Status Updated Successfully",{autoClose:500})},cs=async()=>{if(!f.value)return;await c({method:"post",url:`/v1/order/${m.params.id}`,data:r.value,params:{_method:"PATCH"},headers:{authorization:`Bearer ${authStore.user.token}`}})&&os.success("Payment Status Updated Successfully",{autoClose:500})};return es(u,ps,{deep:!0}),es(r,cs,{deep:!0}),xs(()=>{rs().then(()=>{f.value=!0})}),(n,e)=>{const ms=p("Loading"),fs=p("RouterLink"),y=p("Select"),vs=p("AppLayout");return o(),i(ls,null,[v(ms,{value:ys(us)},null,8,["value"]),v(vs,null,{default:ts(()=>{var _,w,b,g,h,S,j,k,C,V,A,O,P,L,B,T,N,$,D,I,R,U,q,E,F,H,G,J,M,z,Q,W;return[s("div",gs,[s("h3",null,[e[2]||(e[2]=as("Order Id: ")),s("span",hs,a((_=l.value)==null?void 0:_.order_id),1)]),s("div",Ss,[s("div",null,[v(fs,{to:`/order-invoice/${(w=l.value)==null?void 0:w.id}`,class:"bg-common text-white text-sm font-normal px-4 py-2 rounded"},{default:ts(()=>e[3]||(e[3]=[as("Print")])),_:1},8,["to"])]),s("div",null,[e[4]||(e[4]=s("label",{for:"order-status",class:"mb-1 block text-sm"},"Payment Status",-1)),l.value?(o(),ns(y,{key:0,label:"name",class:"w-44",options:is,reduce:t=>t.name,modelValue:r.value.payment_status,"onUpdate:modelValue":e[0]||(e[0]=t=>r.value.payment_status=t)},null,8,["reduce","modelValue"])):x("",!0)]),s("div",null,[e[5]||(e[5]=s("label",{for:"order-status",class:"mb-2 text-sm flex items-center gap-2"}," Order Status ",-1)),l.value?(o(),ns(y,{key:0,label:"name",class:"w-44",options:ds,reduce:t=>t.name,modelValue:u.value.order_status,"onUpdate:modelValue":e[1]||(e[1]=t=>u.value.order_status=t)},null,8,["reduce","modelValue"])):x("",!0)])])]),s("div",js,[s("div",ks,[s("div",Cs,[e[7]||(e[7]=s("h3",{class:"text-lg p-3"},"Order Summery",-1)),s("table",Vs,[e[6]||(e[6]=s("thead",{class:"text-xs text-white uppercase bg-secondary"},[s("tr",null,[s("th",{scope:"col",class:"px-16 py-3"},[s("span",{class:"sr-only"},"Image")]),s("th",{scope:"col",class:"px-6 py-3"}," Varient "),s("th",{scope:"col",class:"px-6 py-3"}," Quantity "),s("th",{scope:"col",class:"px-6 py-3"}," Total ")])],-1)),s("tbody",As,[(o(!0),i(ls,null,_s((b=l.value)==null?void 0:b.order_details,t=>{var K,X,Y,Z,ss;return o(),i("tr",null,[s("td",Os,[s("img",{src:(K=t==null?void 0:t.product)==null?void 0:K.cover_image,class:"w-20 max-w-full max-h-full",alt:"Apple Watch"},null,8,Ps),s("h3",null,a((X=t==null?void 0:t.product)==null?void 0:X.title),1)]),s("td",Ls,a((Y=t==null?void 0:t.stock)==null?void 0:Y.varient),1),s("td",Bs,a(t==null?void 0:t.quantity),1),s("td",Ts," ৳"+a(((Z=t==null?void 0:t.stock)==null?void 0:Z.price)??((ss=t==null?void 0:t.product)==null?void 0:ss.price)),1)])}),256))])])]),s("div",Ns,[s("div",$s,[s("div",Ds,[e[14]||(e[14]=s("h3",{class:"text-lg mb-3"},"Shipping Information",-1)),(g=l.value)!=null&&g.address?(o(),i("div",Is,[s("div",Rs,[e[8]||(e[8]=s("span",null,"Country",-1)),s("span",null,a((S=(h=l.value)==null?void 0:h.address)==null?void 0:S.country),1)]),s("div",Us,[e[9]||(e[9]=s("span",null,"City",-1)),s("span",null,a((k=(j=l.value)==null?void 0:j.address)==null?void 0:k.city),1)]),s("div",qs,[e[10]||(e[10]=s("span",null,"Area",-1)),s("span",null,a((A=(V=(C=l.value)==null?void 0:C.address)==null?void 0:V.area)==null?void 0:A.name),1)]),s("div",Es,[e[11]||(e[11]=s("span",null,"Phone",-1)),s("span",null,a((P=(O=l.value)==null?void 0:O.address)==null?void 0:P.phone),1)]),s("div",Fs,[e[12]||(e[12]=s("span",null,"Email",-1)),s("span",null,a((B=(L=l.value)==null?void 0:L.address)==null?void 0:B.email),1)]),s("div",Hs,[e[13]||(e[13]=s("span",null,"Address",-1)),s("span",null,a((N=(T=l.value)==null?void 0:T.address)==null?void 0:N.address),1)])])):x("",!0),s("div",null,[s("p",null,"Address: "+a(($=l.value)==null?void 0:$.customer_address),1)])])]),s("div",Gs,[s("div",Js,[e[19]||(e[19]=s("h3",{class:"text-lg mb-3"},"Customer Information",-1)),s("div",Ms,[s("div",zs,[e[15]||(e[15]=s("span",null,"Name",-1)),s("span",null,a(((I=(D=l.value)==null?void 0:D.customer)==null?void 0:I.name)??((R=l.value)==null?void 0:R.customer_name)),1)]),s("div",Qs,[e[16]||(e[16]=s("span",null,"Phone",-1)),s("span",null,a(((q=(U=l.value)==null?void 0:U.customer)==null?void 0:q.phone)??((E=l.value)==null?void 0:E.customer_phone)),1)]),s("div",Ws,[e[17]||(e[17]=s("span",null,"Email",-1)),s("span",null,a(((H=(F=l.value)==null?void 0:F.customer)==null?void 0:H.email)??"Guest"),1)]),s("div",Ks,[e[18]||(e[18]=s("span",null,"Joined",-1)),s("span",null,a(((J=(G=l.value)==null?void 0:G.customer)==null?void 0:J.created_at)??"Guest"),1)])])])])])]),s("div",Xs,[s("div",Ys,[e[23]||(e[23]=s("h3",{class:"text-lg mb-4"},"Order Summery",-1)),s("div",Zs,[s("div",se,[e[20]||(e[20]=s("span",null,"Order Created",-1)),s("span",null,a((M=l.value)==null?void 0:M.order_date),1)]),s("div",ee,[e[21]||(e[21]=s("span",null,"Sub Total",-1)),s("span",null,a((z=l.value)==null?void 0:z.sub_total),1)]),s("div",te,[e[22]||(e[22]=s("span",null,"Delivery Fee",-1)),s("span",null,"৳"+a((Q=l.value)==null?void 0:Q.delivery_charge),1)])])]),s("div",le,[s("div",ae,[e[24]||(e[24]=s("span",null,"Total",-1)),s("span",null,"৳"+a((W=l.value)==null?void 0:W.grand_total),1)])])])])]}),_:1})],64)}}};export{ie as default};