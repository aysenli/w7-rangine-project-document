(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-36657fa5"],{"11e9":function(t,e,r){var a=r("52a7"),i=r("4630"),s=r("6821"),o=r("6a99"),n=r("69a8"),l=r("c69a"),c=Object.getOwnPropertyDescriptor;e.f=r("9e1e")?c:function(t,e){if(t=s(t),e=o(e,!0),l)try{return c(t,e)}catch(r){}if(n(t,e))return i(!a.f.call(t,e),t[e])}},"58e0":function(t,e,r){"use strict";var a=r("dc9d"),i=r.n(a);i.a},"5dbc":function(t,e,r){var a=r("d3f4"),i=r("8b97").set;t.exports=function(t,e,r){var s,o=e.constructor;return o!==r&&"function"==typeof o&&(s=o.prototype)!==r.prototype&&a(s)&&i&&i(t,s),t}},"6ccf":function(t,e,r){"use strict";var a=r("76e5"),i=r.n(a);i.a},"76e5":function(t,e,r){},"8b97":function(t,e,r){var a=r("d3f4"),i=r("cb7c"),s=function(t,e){if(i(t),!a(e)&&null!==e)throw TypeError(e+": can't set as prototype!")};t.exports={set:Object.setPrototypeOf||("__proto__"in{}?function(t,e,a){try{a=r("9b43")(Function.call,r("11e9").f(Object.prototype,"__proto__").set,2),a(t,[]),e=!(t instanceof Array)}catch(i){e=!0}return function(t,r){return s(t,r),e?t.__proto__=r:a(t,r),t}}({},!1):void 0),check:s}},9093:function(t,e,r){var a=r("ce10"),i=r("e11e").concat("length","prototype");e.f=Object.getOwnPropertyNames||function(t){return a(t,i)}},"99a4":function(t,e,r){"use strict";r.r(e);var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"container"},[r("div",{staticClass:"page-head"},[r("router-link",{attrs:{to:"/admin/user"}},[r("i",{staticClass:"el-icon-arrow-left"}),r("span",{staticStyle:{color:"#4da4fb"}},[t._v("用户管理")])]),t._v("/"),r("span",[t._v(t._s(t.$route.params.id?"编辑用户":"添加用户"))])],1),t.$route.params.id?t._e():r("div",{staticClass:"title"},[r("span",{staticClass:"active"},[t._v("1.添加成员")]),r("div",{staticClass:"title-line"}),r("span",{class:{active:!t.firstPage}},[t._v("2.设置权限")])]),r("div",{staticClass:"content"},[t.firstPage?[r("el-form",{ref:"ruleForm",staticStyle:{width:"420px"},attrs:{model:t.formData,rules:t.rules,"label-width":"80px","label-position":"left"}},[r("el-form-item",{attrs:{label:"用户账号",prop:"username"}},[r("el-input",{model:{value:t.formData.username,callback:function(e){t.$set(t.formData,"username",e)},expression:"formData.username"}})],1),r("el-form-item",{attrs:{label:"密码",prop:"userpass"}},[r("el-input",{attrs:{type:"password"},model:{value:t.formData.userpass,callback:function(e){t.$set(t.formData,"userpass",e)},expression:"formData.userpass"}})],1),r("el-form-item",{attrs:{label:"确认密码",prop:"confirm_userpass"}},[r("el-input",{attrs:{type:"password"},model:{value:t.formData.confirm_userpass,callback:function(e){t.$set(t.formData,"confirm_userpass",e)},expression:"formData.confirm_userpass"}})],1),r("el-form-item",[r("el-button",{attrs:{type:"primary"},on:{click:t.onSubmit}},[t._v("下一步")])],1)],1)]:[r("permission",{attrs:{user_id:t.user_id}})]],2)])},i=[],s=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("el-container",{staticClass:"user-permission"},[r("el-aside",{attrs:{width:"150px"}},[t._v("项目权限")]),r("el-main",[r("div",{staticClass:"select-power search-box"},[r("el-select",{attrs:{placeholder:"请选择"},on:{change:t.search},model:{value:t.is_public,callback:function(e){t.is_public=e},expression:"is_public"}},[r("el-option",{attrs:{label:"全部项目",value:"0"}}),r("el-option",{attrs:{label:"公有项目",value:"1"}}),r("el-option",{attrs:{label:"私有项目",value:"2"}})],1),r("div",{staticClass:"demo-input-suffix"},[r("el-input",{attrs:{placeholder:"请输入项目名称",clearable:""},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.search(e)}},model:{value:t.keyword,callback:function(e){t.keyword=e},expression:"keyword"}},[r("i",{staticClass:"el-input__icon el-icon-search",attrs:{slot:"suffix"},on:{click:t.search},slot:"suffix"})])],1),t._e()],1),r("el-table",{ref:"multipleTable",staticClass:"w7-table",attrs:{data:t.docList,"empty-text":"","row-key":"id","header-cell-style":{background:"#f7f9fc",color:"#606266"}}},[t._e(),r("el-table-column",{attrs:{label:"项目名称"},scopedSlots:t._u([{key:"default",fn:function(e){return[r("i",{staticClass:"wi wi-folder"}),r("span",{staticStyle:{"margin-left":"10px"}},[t._v(t._s(e.row.name))]),e.row.is_public?t._e():r("div",{staticStyle:{display:"inline-block",padding:"0 5px","margin-left":"20px",background:"#fff1de",color:"#ff8600"}},[r("i",{staticClass:"el-icon-lock"},[r("span",{staticStyle:{"margin-left":"5px"}},[t._v("私有")])])])]}}])}),r("el-table-column",{attrs:{label:"权限",align:"right"},scopedSlots:t._u([{key:"default",fn:function(e){return[r("el-radio-group",{staticClass:"ownership",model:{value:e.row.cur_role,callback:function(r){t.$set(e.row,"cur_role",r)},expression:"scope.row.cur_role"}},[t._l(e.row.role_list,(function(e){return[1==e.id?r("el-tooltip",{key:e.id,attrs:{effect:"dark",content:"可管理成员、阅读和编辑文档",placement:"bottom"}},[r("el-radio",{attrs:{label:1}},[t._v(t._s(e.name))])],1):t._e(),2==e.id?r("el-tooltip",{key:e.id,attrs:{effect:"dark",content:"可阅读和编辑文档",placement:"bottom"}},[r("el-radio",{attrs:{label:2}},[t._v(t._s(e.name))])],1):t._e(),3==e.id?r("el-tooltip",{key:e.id,attrs:{effect:"dark",content:"仅可以阅读",placement:"bottom"}},[r("el-radio",{attrs:{label:3}},[t._v(t._s(e.name))])],1):t._e()]}))],2)]}}])}),r("div",{staticClass:"nodata",attrs:{slot:"empty"},slot:"empty"},[r("p",[t._v("暂无可以查看管理的文档")])])],1),t.currentPage!=t.pageCount&&t.pageCount>1?r("div",{staticClass:"get-more"},[r("el-button",{attrs:{type:"text"},on:{click:t.getMore}},[t._v("点击加载更多")])],1):t._e(),r("div",{staticClass:"btns"},[r("el-button",{attrs:{type:"primary"},on:{click:t.save}},[t._v("保存")])],1)],1),r("el-dialog",{staticClass:"w7-dialog",attrs:{title:"批量修改",visible:t.dialogEditInfoVisible,"close-on-click-modal":!1,center:""},on:{"update:visible":function(e){t.dialogEditInfoVisible=e}}},[r("el-form",{staticStyle:{"margin-left":"50px"},attrs:{"label-width":"120"}},[r("el-form-item",{attrs:{label:"公有项目"}},[r("el-radio-group",{staticClass:"ownership",model:{value:t.radio,callback:function(e){t.radio=e},expression:"radio"}},[r("el-radio",{attrs:{label:2}},[t._v("操作员")])],1)],1),r("el-form-item",{attrs:{label:"私有项目"}},[r("el-radio-group",{staticClass:"ownership",model:{value:t.radio1,callback:function(e){t.radio1=e},expression:"radio1"}},[r("el-radio",{attrs:{label:2}},[t._v("操作员")]),r("el-radio",{attrs:{label:3}},[t._v("阅读者")])],1)],1)],1),r("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[r("el-button",{attrs:{type:"primary"},on:{click:t.editAll}},[t._v("确 定")]),r("el-button",{on:{click:function(e){t.dialogEditInfoVisible=!1}}},[t._v("取 消")])],1)],1)],1)},o=[];r("c5f6");function n(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,a=new Array(e);r<e;r++)a[r]=t[r];return a}function l(t){if(Array.isArray(t))return n(t)}function c(t){if("undefined"!==typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}function u(t,e){if(t){if("string"===typeof t)return n(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);return"Object"===r&&t.constructor&&(r=t.constructor.name),"Map"===r||"Set"===r?Array.from(t):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?n(t,e):void 0}}function f(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}function d(t){return l(t)||c(t)||u(t)||f()}var p={props:["user_id"],data:function(){return{is_public:"",keyword:"",docList:[],currentPage:1,pageCount:1,total:0,dialogEditInfoVisible:!1,radio:2,radio1:2,selectRows:[]}},created:function(){this.getList()},methods:{search:function(){this.currentPage=1,this.getList()},getMore:function(){this.currentPage++,this.getList("more")},getList:function(t){var e=this;this.$post("/admin/document/all-by-uid",{user_id:this.user_id,page:this.currentPage,name:this.keyword,is_public:this.is_public}).then((function(r){e.docList="more"==t?[].concat(d(e.docList),d(r.data.data)):r.data.data,e.pageCount=r.data.page_count,e.total=r.data.total}))},save:function(){var t=this,e=[];for(var r in this.docList)this.docList[r].cur_role&&e.push({document_id:this.docList[r].id,permission:this.docList[r].cur_role});e.length?this.$post("/admin/user/batch-update-permission",{user_id:this.user_id,document_permission:e}).then((function(){t.$message("保存成功！"),t.$router.push("/admin/user")})):this.$router.push("/admin/user")},editAll:function(){var t=this.$refs.multipleTable.selection;for(var e in t)t[e].is_public?t[e].cur_role=Number(this.radio):t[e].cur_role=Number(this.radio1);this.dialogEditInfoVisible=!1}}},m=p,b=(r("6ccf"),r("2877")),_=Object(b["a"])(m,s,o,!1,null,null,null),v=_.exports,h={components:{permission:v},data:function(){var t=this,e=function(e,r,a){""===r?a(new Error("请输入密码")):(""!==t.formData.confirm_userpass&&t.$refs.ruleForm.validateField("confirm_userpass"),a())},r=function(e,r,a){""===r?a(new Error("请再次输入密码")):r!==t.formData.userpass?a(new Error("两次输入密码不一致!")):a()};return{rules:{username:[{required:!0,message:"请输入用户账号",trigger:"blur"}],userpass:[{required:!0,validator:e,trigger:"blur"}],confirm_userpass:[{required:!0,validator:r,trigger:"blur"}]},firstPage:!0,formData:{id:this.$route.params.id,username:"",userpass:"",confirm_userpass:""},user_id:""}},created:function(){this.$route.params.id&&(this.user_id=this.$route.params.id,this.firstPage=!1)},methods:{onSubmit:function(){var t=this;this.$refs["ruleForm"].validate((function(e){e&&t.$post("/admin/user/add",t.formData).then((function(e){t.$message("创建成功！"),t.user_id=e.data,t.firstPage=!1}))}))}}},g=h,y=(r("58e0"),Object(b["a"])(g,a,i,!1,null,"5df92025",null));e["default"]=y.exports},aa77:function(t,e,r){var a=r("5ca1"),i=r("be13"),s=r("79e5"),o=r("fdef"),n="["+o+"]",l="​",c=RegExp("^"+n+n+"*"),u=RegExp(n+n+"*$"),f=function(t,e,r){var i={},n=s((function(){return!!o[t]()||l[t]()!=l})),c=i[t]=n?e(d):o[t];r&&(i[r]=c),a(a.P+a.F*n,"String",i)},d=f.trim=function(t,e){return t=String(i(t)),1&e&&(t=t.replace(c,"")),2&e&&(t=t.replace(u,"")),t};t.exports=f},c5f6:function(t,e,r){"use strict";var a=r("7726"),i=r("69a8"),s=r("2d95"),o=r("5dbc"),n=r("6a99"),l=r("79e5"),c=r("9093").f,u=r("11e9").f,f=r("86cc").f,d=r("aa77").trim,p="Number",m=a[p],b=m,_=m.prototype,v=s(r("2aeb")(_))==p,h="trim"in String.prototype,g=function(t){var e=n(t,!1);if("string"==typeof e&&e.length>2){e=h?e.trim():d(e,3);var r,a,i,s=e.charCodeAt(0);if(43===s||45===s){if(r=e.charCodeAt(2),88===r||120===r)return NaN}else if(48===s){switch(e.charCodeAt(1)){case 66:case 98:a=2,i=49;break;case 79:case 111:a=8,i=55;break;default:return+e}for(var o,l=e.slice(2),c=0,u=l.length;c<u;c++)if(o=l.charCodeAt(c),o<48||o>i)return NaN;return parseInt(l,a)}}return+e};if(!m(" 0o1")||!m("0b1")||m("+0x1")){m=function(t){var e=arguments.length<1?0:t,r=this;return r instanceof m&&(v?l((function(){_.valueOf.call(r)})):s(r)!=p)?o(new b(g(e)),r,m):g(e)};for(var y,k=r("9e1e")?c(b):"MAX_VALUE,MIN_VALUE,NaN,NEGATIVE_INFINITY,POSITIVE_INFINITY,EPSILON,isFinite,isInteger,isNaN,isSafeInteger,MAX_SAFE_INTEGER,MIN_SAFE_INTEGER,parseFloat,parseInt,isInteger".split(","),w=0;k.length>w;w++)i(b,y=k[w])&&!i(m,y)&&f(m,y,u(b,y));m.prototype=_,_.constructor=m,r("2aba")(a,p,m)}},dc9d:function(t,e,r){},fdef:function(t,e){t.exports="\t\n\v\f\r   ᠎             　\u2028\u2029\ufeff"}}]);