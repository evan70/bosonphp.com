/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const z=globalThis,I=z.ShadowRoot&&(z.ShadyCSS===void 0||z.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,R=Symbol(),V=new WeakMap;let ee=class{constructor(e,t,i){if(this._$cssResult$=!0,i!==R)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=e,this.t=t}get styleSheet(){let e=this.o;const t=this.t;if(I&&e===void 0){const i=t!==void 0&&t.length===1;i&&(e=V.get(t)),e===void 0&&((this.o=e=new CSSStyleSheet).replaceSync(this.cssText),i&&V.set(t,e))}return e}toString(){return this.cssText}};const ne=o=>new ee(typeof o=="string"?o:o+"",void 0,R),h=(o,...e)=>{const t=o.length===1?o[0]:e.reduce((i,s,r)=>i+(n=>{if(n._$cssResult$===!0)return n.cssText;if(typeof n=="number")return n;throw Error("Value passed to 'css' function must be a 'css' function result: "+n+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+o[r+1],o[0]);return new ee(t,o,R)},ae=(o,e)=>{if(I)o.adoptedStyleSheets=e.map(t=>t instanceof CSSStyleSheet?t:t.styleSheet);else for(const t of e){const i=document.createElement("style"),s=z.litNonce;s!==void 0&&i.setAttribute("nonce",s),i.textContent=t.cssText,o.appendChild(i)}},q=I?o=>o:o=>o instanceof CSSStyleSheet?(e=>{let t="";for(const i of e.cssRules)t+=i.cssText;return ne(t)})(o):o;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:le,defineProperty:de,getOwnPropertyDescriptor:ce,getOwnPropertyNames:he,getOwnPropertySymbols:pe,getPrototypeOf:me}=Object,M=globalThis,F=M.trustedTypes,ue=F?F.emptyScript:"",fe=M.reactiveElementPolyfillSupport,k=(o,e)=>o,j={toAttribute(o,e){switch(e){case Boolean:o=o?ue:null;break;case Object:case Array:o=o==null?o:JSON.stringify(o)}return o},fromAttribute(o,e){let t=o;switch(e){case Boolean:t=o!==null;break;case Number:t=o===null?null:Number(o);break;case Object:case Array:try{t=JSON.parse(o)}catch{t=null}}return t}},te=(o,e)=>!le(o,e),Y={attribute:!0,type:String,converter:j,reflect:!1,useDefault:!1,hasChanged:te};Symbol.metadata??=Symbol("metadata"),M.litPropertyMetadata??=new WeakMap;let _=class extends HTMLElement{static addInitializer(e){this._$Ei(),(this.l??=[]).push(e)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(e,t=Y){if(t.state&&(t.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(e)&&((t=Object.create(t)).wrapped=!0),this.elementProperties.set(e,t),!t.noAccessor){const i=Symbol(),s=this.getPropertyDescriptor(e,i,t);s!==void 0&&de(this.prototype,e,s)}}static getPropertyDescriptor(e,t,i){const{get:s,set:r}=ce(this.prototype,e)??{get(){return this[t]},set(n){this[t]=n}};return{get:s,set(n){const p=s?.call(this);r?.call(this,n),this.requestUpdate(e,p,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(e){return this.elementProperties.get(e)??Y}static _$Ei(){if(this.hasOwnProperty(k("elementProperties")))return;const e=me(this);e.finalize(),e.l!==void 0&&(this.l=[...e.l]),this.elementProperties=new Map(e.elementProperties)}static finalize(){if(this.hasOwnProperty(k("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(k("properties"))){const t=this.properties,i=[...he(t),...pe(t)];for(const s of i)this.createProperty(s,t[s])}const e=this[Symbol.metadata];if(e!==null){const t=litPropertyMetadata.get(e);if(t!==void 0)for(const[i,s]of t)this.elementProperties.set(i,s)}this._$Eh=new Map;for(const[t,i]of this.elementProperties){const s=this._$Eu(t,i);s!==void 0&&this._$Eh.set(s,t)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(e){const t=[];if(Array.isArray(e)){const i=new Set(e.flat(1/0).reverse());for(const s of i)t.unshift(q(s))}else e!==void 0&&t.push(q(e));return t}static _$Eu(e,t){const i=t.attribute;return i===!1?void 0:typeof i=="string"?i:typeof e=="string"?e.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),this.constructor.l?.forEach(e=>e(this))}addController(e){(this._$EO??=new Set).add(e),this.renderRoot!==void 0&&this.isConnected&&e.hostConnected?.()}removeController(e){this._$EO?.delete(e)}_$E_(){const e=new Map,t=this.constructor.elementProperties;for(const i of t.keys())this.hasOwnProperty(i)&&(e.set(i,this[i]),delete this[i]);e.size>0&&(this._$Ep=e)}createRenderRoot(){const e=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return ae(e,this.constructor.elementStyles),e}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$EO?.forEach(e=>e.hostConnected?.())}enableUpdating(e){}disconnectedCallback(){this._$EO?.forEach(e=>e.hostDisconnected?.())}attributeChangedCallback(e,t,i){this._$AK(e,i)}_$ET(e,t){const i=this.constructor.elementProperties.get(e),s=this.constructor._$Eu(e,i);if(s!==void 0&&i.reflect===!0){const r=(i.converter?.toAttribute!==void 0?i.converter:j).toAttribute(t,i.type);this._$Em=e,r==null?this.removeAttribute(s):this.setAttribute(s,r),this._$Em=null}}_$AK(e,t){const i=this.constructor,s=i._$Eh.get(e);if(s!==void 0&&this._$Em!==s){const r=i.getPropertyOptions(s),n=typeof r.converter=="function"?{fromAttribute:r.converter}:r.converter?.fromAttribute!==void 0?r.converter:j;this._$Em=s;const p=n.fromAttribute(t,r.type);this[s]=p??this._$Ej?.get(s)??p,this._$Em=null}}requestUpdate(e,t,i){if(e!==void 0){const s=this.constructor,r=this[e];if(i??=s.getPropertyOptions(e),!((i.hasChanged??te)(r,t)||i.useDefault&&i.reflect&&r===this._$Ej?.get(e)&&!this.hasAttribute(s._$Eu(e,i))))return;this.C(e,t,i)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(e,t,{useDefault:i,reflect:s,wrapped:r},n){i&&!(this._$Ej??=new Map).has(e)&&(this._$Ej.set(e,n??t??this[e]),r!==!0||n!==void 0)||(this._$AL.has(e)||(this.hasUpdated||i||(t=void 0),this._$AL.set(e,t)),s===!0&&this._$Em!==e&&(this._$Eq??=new Set).add(e))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(t){Promise.reject(t)}const e=this.scheduleUpdate();return e!=null&&await e,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[s,r]of this._$Ep)this[s]=r;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[s,r]of i){const{wrapped:n}=r,p=this[s];n!==!0||this._$AL.has(s)||p===void 0||this.C(s,void 0,r,p)}}let e=!1;const t=this._$AL;try{e=this.shouldUpdate(t),e?(this.willUpdate(t),this._$EO?.forEach(i=>i.hostUpdate?.()),this.update(t)):this._$EM()}catch(i){throw e=!1,this._$EM(),i}e&&this._$AE(t)}willUpdate(e){}_$AE(e){this._$EO?.forEach(t=>t.hostUpdated?.()),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(e)),this.updated(e)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(e){return!0}update(e){this._$Eq&&=this._$Eq.forEach(t=>this._$ET(t,this[t])),this._$EM()}updated(e){}firstUpdated(e){}};_.elementStyles=[],_.shadowRootOptions={mode:"open"},_[k("elementProperties")]=new Map,_[k("finalized")]=new Map,fe?.({ReactiveElement:_}),(M.reactiveElementVersions??=[]).push("2.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const W=globalThis,O=W.trustedTypes,K=O?O.createPolicy("lit-html",{createHTML:o=>o}):void 0,ie="$lit$",b=`lit$${Math.random().toFixed(9).slice(2)}$`,se="?"+b,ge=`<${se}>`,w=document,P=()=>w.createComment(""),C=o=>o===null||typeof o!="object"&&typeof o!="function",D=Array.isArray,ve=o=>D(o)||typeof o?.[Symbol.iterator]=="function",U=`[ 	
\f\r]`,S=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,G=/-->/g,J=/>/g,y=RegExp(`>|${U}(?:([^\\s"'>=/]+)(${U}*=${U}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),Z=/'/g,X=/"/g,oe=/^(?:script|style|textarea|title)$/i,xe=o=>(e,...t)=>({_$litType$:o,strings:e,values:t}),l=xe(1),A=Symbol.for("lit-noChange"),u=Symbol.for("lit-nothing"),Q=new WeakMap,$=w.createTreeWalker(w,129);function re(o,e){if(!D(o)||!o.hasOwnProperty("raw"))throw Error("invalid template strings array");return K!==void 0?K.createHTML(e):e}const be=(o,e)=>{const t=o.length-1,i=[];let s,r=e===2?"<svg>":e===3?"<math>":"",n=S;for(let p=0;p<t;p++){const a=o[p];let m,g,c=-1,v=0;for(;v<a.length&&(n.lastIndex=v,g=n.exec(a),g!==null);)v=n.lastIndex,n===S?g[1]==="!--"?n=G:g[1]!==void 0?n=J:g[2]!==void 0?(oe.test(g[2])&&(s=RegExp("</"+g[2],"g")),n=y):g[3]!==void 0&&(n=y):n===y?g[0]===">"?(n=s??S,c=-1):g[1]===void 0?c=-2:(c=n.lastIndex-g[2].length,m=g[1],n=g[3]===void 0?y:g[3]==='"'?X:Z):n===X||n===Z?n=y:n===G||n===J?n=S:(n=y,s=void 0);const x=n===y&&o[p+1].startsWith("/>")?" ":"";r+=n===S?a+ge:c>=0?(i.push(m),a.slice(0,c)+ie+a.slice(c)+b+x):a+b+(c===-2?p:x)}return[re(o,r+(o[t]||"<?>")+(e===2?"</svg>":e===3?"</math>":"")),i]};class H{constructor({strings:e,_$litType$:t},i){let s;this.parts=[];let r=0,n=0;const p=e.length-1,a=this.parts,[m,g]=be(e,t);if(this.el=H.createElement(m,i),$.currentNode=this.el.content,t===2||t===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(s=$.nextNode())!==null&&a.length<p;){if(s.nodeType===1){if(s.hasAttributes())for(const c of s.getAttributeNames())if(c.endsWith(ie)){const v=g[n++],x=s.getAttribute(c).split(b),T=/([.?@])?(.*)/.exec(v);a.push({type:1,index:r,name:T[2],strings:x,ctor:T[1]==="."?$e:T[1]==="?"?we:T[1]==="@"?_e:N}),s.removeAttribute(c)}else c.startsWith(b)&&(a.push({type:6,index:r}),s.removeAttribute(c));if(oe.test(s.tagName)){const c=s.textContent.split(b),v=c.length-1;if(v>0){s.textContent=O?O.emptyScript:"";for(let x=0;x<v;x++)s.append(c[x],P()),$.nextNode(),a.push({type:2,index:++r});s.append(c[v],P())}}}else if(s.nodeType===8)if(s.data===se)a.push({type:2,index:r});else{let c=-1;for(;(c=s.data.indexOf(b,c+1))!==-1;)a.push({type:7,index:r}),c+=b.length-1}r++}}static createElement(e,t){const i=w.createElement("template");return i.innerHTML=e,i}}function E(o,e,t=o,i){if(e===A)return e;let s=i!==void 0?t._$Co?.[i]:t._$Cl;const r=C(e)?void 0:e._$litDirective$;return s?.constructor!==r&&(s?._$AO?.(!1),r===void 0?s=void 0:(s=new r(o),s._$AT(o,t,i)),i!==void 0?(t._$Co??=[])[i]=s:t._$Cl=s),s!==void 0&&(e=E(o,s._$AS(o,e.values),s,i)),e}class ye{constructor(e,t){this._$AV=[],this._$AN=void 0,this._$AD=e,this._$AM=t}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(e){const{el:{content:t},parts:i}=this._$AD,s=(e?.creationScope??w).importNode(t,!0);$.currentNode=s;let r=$.nextNode(),n=0,p=0,a=i[0];for(;a!==void 0;){if(n===a.index){let m;a.type===2?m=new B(r,r.nextSibling,this,e):a.type===1?m=new a.ctor(r,a.name,a.strings,this,e):a.type===6&&(m=new Ae(r,this,e)),this._$AV.push(m),a=i[++p]}n!==a?.index&&(r=$.nextNode(),n++)}return $.currentNode=w,s}p(e){let t=0;for(const i of this._$AV)i!==void 0&&(i.strings!==void 0?(i._$AI(e,i,t),t+=i.strings.length-2):i._$AI(e[t])),t++}}class B{get _$AU(){return this._$AM?._$AU??this._$Cv}constructor(e,t,i,s){this.type=2,this._$AH=u,this._$AN=void 0,this._$AA=e,this._$AB=t,this._$AM=i,this.options=s,this._$Cv=s?.isConnected??!0}get parentNode(){let e=this._$AA.parentNode;const t=this._$AM;return t!==void 0&&e?.nodeType===11&&(e=t.parentNode),e}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(e,t=this){e=E(this,e,t),C(e)?e===u||e==null||e===""?(this._$AH!==u&&this._$AR(),this._$AH=u):e!==this._$AH&&e!==A&&this._(e):e._$litType$!==void 0?this.$(e):e.nodeType!==void 0?this.T(e):ve(e)?this.k(e):this._(e)}O(e){return this._$AA.parentNode.insertBefore(e,this._$AB)}T(e){this._$AH!==e&&(this._$AR(),this._$AH=this.O(e))}_(e){this._$AH!==u&&C(this._$AH)?this._$AA.nextSibling.data=e:this.T(w.createTextNode(e)),this._$AH=e}$(e){const{values:t,_$litType$:i}=e,s=typeof i=="number"?this._$AC(e):(i.el===void 0&&(i.el=H.createElement(re(i.h,i.h[0]),this.options)),i);if(this._$AH?._$AD===s)this._$AH.p(t);else{const r=new ye(s,this),n=r.u(this.options);r.p(t),this.T(n),this._$AH=r}}_$AC(e){let t=Q.get(e.strings);return t===void 0&&Q.set(e.strings,t=new H(e)),t}k(e){D(this._$AH)||(this._$AH=[],this._$AR());const t=this._$AH;let i,s=0;for(const r of e)s===t.length?t.push(i=new B(this.O(P()),this.O(P()),this,this.options)):i=t[s],i._$AI(r),s++;s<t.length&&(this._$AR(i&&i._$AB.nextSibling,s),t.length=s)}_$AR(e=this._$AA.nextSibling,t){for(this._$AP?.(!1,!0,t);e!==this._$AB;){const i=e.nextSibling;e.remove(),e=i}}setConnected(e){this._$AM===void 0&&(this._$Cv=e,this._$AP?.(e))}}class N{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(e,t,i,s,r){this.type=1,this._$AH=u,this._$AN=void 0,this.element=e,this.name=t,this._$AM=s,this.options=r,i.length>2||i[0]!==""||i[1]!==""?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=u}_$AI(e,t=this,i,s){const r=this.strings;let n=!1;if(r===void 0)e=E(this,e,t,0),n=!C(e)||e!==this._$AH&&e!==A,n&&(this._$AH=e);else{const p=e;let a,m;for(e=r[0],a=0;a<r.length-1;a++)m=E(this,p[i+a],t,a),m===A&&(m=this._$AH[a]),n||=!C(m)||m!==this._$AH[a],m===u?e=u:e!==u&&(e+=(m??"")+r[a+1]),this._$AH[a]=m}n&&!s&&this.j(e)}j(e){e===u?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,e??"")}}class $e extends N{constructor(){super(...arguments),this.type=3}j(e){this.element[this.name]=e===u?void 0:e}}class we extends N{constructor(){super(...arguments),this.type=4}j(e){this.element.toggleAttribute(this.name,!!e&&e!==u)}}class _e extends N{constructor(e,t,i,s,r){super(e,t,i,s,r),this.type=5}_$AI(e,t=this){if((e=E(this,e,t,0)??u)===A)return;const i=this._$AH,s=e===u&&i!==u||e.capture!==i.capture||e.once!==i.once||e.passive!==i.passive,r=e!==u&&(i===u||s);s&&this.element.removeEventListener(this.name,this,i),r&&this.element.addEventListener(this.name,this,e),this._$AH=e}handleEvent(e){typeof this._$AH=="function"?this._$AH.call(this.options?.host??this.element,e):this._$AH.handleEvent(e)}}class Ae{constructor(e,t,i){this.element=e,this.type=6,this._$AN=void 0,this._$AM=t,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(e){E(this,e)}}const Ee=W.litHtmlPolyfillSupport;Ee?.(H,B),(W.litHtmlVersions??=[]).push("3.3.1");const Se=(o,e,t)=>{const i=t?.renderBefore??e;let s=i._$litPart$;if(s===void 0){const r=t?.renderBefore??null;i._$litPart$=s=new B(e.insertBefore(P(),r),r,void 0,t??{})}return s._$AI(o),s};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const L=globalThis;class d extends _{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){const e=super.createRenderRoot();return this.renderOptions.renderBefore??=e.firstChild,e}update(e){const t=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(e),this._$Do=Se(t,this.renderRoot,this.renderOptions)}connectedCallback(){super.connectedCallback(),this._$Do?.setConnected(!0)}disconnectedCallback(){super.disconnectedCallback(),this._$Do?.setConnected(!1)}render(){return A}}d._$litElement$=!0,d.finalized=!0,L.litElementHydrateSupport?.({LitElement:d});const ke=L.litElementPolyfillSupport;ke?.({LitElement:d});(L.litElementVersions??=[]).push("4.2.1");const f=h`
    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-title);
        color: var(--color-text);
        margin: 0;
        padding: 0;
    }

    p {
        color: var(--color-text-secondary);
        margin: 0;
        padding: 0;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    * {
        box-sizing: border-box;
    }
`;class Pe extends d{static properties={href:{type:String},text:{type:String}};static styles=[f,h`
        .button {
            transition-duration: 0.2s;
            background: var(--color-bg-button);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 1em;
            text-transform: uppercase;
        }

        .button:hover {
            background: var(--color-bg-button-hover);
        }

        .text {
            margin-left: 1em;
            color: var(--color-text-button);
        }

        .box {
            height: 35px;
            width: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button);
        }
    `];constructor(){super(),this.href="/",this.text=""}render(){return l`
            <a href="${this.href}" class="button">
                <span class="text">${this.text}</span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_primary.svg" alt="arrow_primary"/>
                </div>
            </a>
        `}}customElements.define("button-primary",Pe);class Ce extends d{static properties={href:{type:String},text:{type:String}};static styles=[f,h`
        .button {
            transition-duration: 0.2s;
            background: var(--color-bg-button-secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 1em;
            text-transform: uppercase;
        }

        .button:hover {
            background: var(--color-bg-button-secondary-hover);
        }

        .text {
            margin-left: 1em;
            color: var(--color-text-button-secondary);
        }

        .box {
            height: 35px;
            width: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button-secondary);
        }
    `];constructor(){super(),this.href="/",this.text=""}render(){return l`
            <a href="${this.href}" class="button">
                <span class="text">${this.text}</span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_secondary.svg" alt="arrow_secondary"/>
                </div>
            </a>
        `}}customElements.define("button-secondary",Ce);class He extends d{static styles=[f,h`
        .container {
            padding-bottom: 8em;
            background-size: 900px 900px;
            background: url("/images/hero.svg") no-repeat 115% 0;
        }

        .wrapper {
            width: var(--width-content);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 3em;
            align-items: flex-start;
        }

        .red {
            color: var(--color-text-brand);
        }

        .text h1 {
            font-size: max(2rem, min(2rem + 1vw, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }
    `];render(){return l`
            <section class="container">
                <div class="wrapper">
                    <div class="text">
                        <h1>If you are a PHP developer, you can already</h1>
                        <h1>make native cross-platform applications.</h1>
                        <h1>Boson PHP makes it possible!</h1>
                        <h1 class="red">Get started right now!</h1>
                    </div>
                    <button-primary text="Try Boson For Free" href="/"></button-primary>
                </div>
            </section>
        `}}customElements.define("call-to-action-section",He);class Be extends d{static styles=[f,h`
        .container {
            display: flex;
            flex-direction: column;
            width: var(--width-content);
            margin: 0 auto;
        }

        .top {
            display: flex;
            flex-direction: row;
            align-items: center;
            flex: 1;
            gap: 2em;
            justify-content: space-between;
            padding: 8em 0;
        }

        .text {
            flex: 3;
            display: flex;
            flex-direction: column;
            gap: 3em;
        }

        .img {
            flex: 2;
        }

        .headlines {
            font-size: clamp(4rem, 1vw + 4.5rem, 7rem);
            line-height: 1.1;
        }

        .headlines h1:nth-child(1) {
            color: var(--color-text-brand);
        }

        .description {
            width: 80%;
            line-height: 1.75;
            font-size: clamp(1rem, 0.55vw + 0.55rem, 2rem);
        }

        .buttons {
            display: flex;
            flex-direction: row;
            gap: 3em;
        }

        .bottom {
            padding: 3em 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition-duration: 0.2s;
            border-top: 1px solid var(--color-border);
        }

        .bottom:hover {
            padding: 3em 2em;
            background-color: var(--color-bg-hover);
        }

        .bottom span {
            text-transform: uppercase;
        }
    `];render(){return l`
            <section class="container">
                <div class="top">
                    <div class="text">
                        <div class="headlines">
                            <h1>Go Native.</h1>
                            <h1>Stay PHP</h1>
                        </div>
                        <p class="description">Turn your PHP project into cross-platform, compact, fast, native
                            applications for Windows, macOS, Linux, Android and iOS.</p>
                        <div class="buttons">
                            <button-primary text="Try Boson for Free" href="/"></button-primary>
                            <button-secondary text="Watch Presentation" href="/"></button-secondary>
                        </div>
                    </div>
                    <img class="img" src="/images/hero.svg" alt="hero"/>
                </div>

                <a href="#nativeness" class="bottom">
                    <span>Discover more about boson</span>
                    <img src="/images/icons/arrow_down.svg" alt="arrow_down"/>
                </a>
            </section>
        `}}customElements.define("hero-section",Be);class Te extends d{static styles=[f,h`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            width: var(--width-content);
            margin: 0 auto;
        }

        .left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2em;
        }

        .text h1 {
            font-size: max(3rem, min(1vw + 3.5rem, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }

        .right {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            max-width: clamp(650px, 40vw, 800px);
            gap: 1em;
        }

        .right p {
            transform: translateY(-6px);
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }

        .content {
            display: flex;
            padding: 1px 0;
            border-bottom: 1px solid var(--color-border);
            border-top: 1px solid var(--color-border);
        }

        .dots {
            min-width: 120px;
        }

        .content .dots:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .inner {
            display: flex;
            flex: 1;
        }
    `];get content(){return[{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a falications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson antly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create and resource consumption, significantly outperforming Electron in terms of performance."}]}render(){return l`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="How It Works"></subtitle-component>
                        <div class="text">
                            <h1>Under the Hood of</h1>
                            <h1>Boson PHP</h1>
                        </div>
                    </div>
                    <div class="right">
                        <p>Why Boson? Because it's not Electron! And much simpler =)</p>
                        <p>Want to know what makes Boson PHP so compact, fast and versatile? We don't use Electron.
                            Instead, our solution is based on simple, yet robust and up-to-date technologies that
                            provide native performance and lightweight across all platforms.</p>
                    </div>
                </div>
                <div class="content">
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <div class="inner">
                        <horizontal-accordion .content=${this.content}></horizontal-accordion>
                    </div>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                </div>
            </section>
        `}}customElements.define("how-it-works-section",Te);class ze extends d{static styles=[f,h`
        .container {
            display: flex;
            justify-content: center;
            position: relative;
            border-top: 1px solid var(--color-border);
        }

        .left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-self: stretch;
            position: relative;
            border-right: 1px solid var(--color-border);
            border-bottom: 1px solid var(--color-border);
        }

        .wrapper {
            top: 10em;
            position: sticky;
            gap: 3em;
            display: flex;
            padding: 4em 6em;
            flex-direction: column;
            align-items: flex-start;
        }

        .right {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .red {
            color: var(--color-text-brand);
        }

        .description {
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }

        .headline h1 {
            font-size: max(3rem, min(1vw + 3.5rem, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }

        .element {
            border-bottom: 1px solid var(--color-border);
            padding: 4em;
            display: flex;
            flex-direction: column;
            gap: 1.5em;
        }

        .top {
            display: flex;
            align-items: center;
            gap: 1.5em;
        }

        .name {
            font-weight: 500;
        }

        .text {
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }
    `];get elements(){return[{text:"For many businesses, mobile devices are the main audience segment. Web applications are good. Desktop clients are great. Mobile applications are wonderful.",icon:"rocket",headline:"Reaching new audiences"},{text:"The same PHP code — but now it works on a mobile device. Budget savings and faster launch.",icon:"clients",headline:"New clients without rewriting code"},{headline:"Convenient for B2B and B2C",icon:"case",text:"Internal CRM, chat applications, offline utilities, task managers, task trackers, dashboards — you can carry everything in your pocket."},{headline:"Without pain and extra stacks",icon:"convenient",text:"One stack. One language. One project. PHP from start to launch in the App Store."}]}renderElement(e){return l`
            <div class="element">
                <div class="top">
                    <img class="icon" src="/images/icons/${e.icon}.svg" alt="${e.headline}"/>
                    <h2 class="name">${e.headline}</h2>
                </div>
                <p class="text">${e.text}</p>
            </div>
        `}render(){return l`
            <section class="container">
                <div class="left">
                    <div class="wrapper">
                        <subtitle-component name="Mobile Development"></subtitle-component>
                        <div class="headline">
                            <h1>Expand Your</h1>
                            <h1>Business Horizons:</h1>
                            <h1 class="red">PHP Mobile Apps</h1>
                        </div>
                        <p class="description">With Boson PHP Mobile, you can run your PHP app on Android and iOS -
                            without learning Swift, Kotlin or React Native.</p>
                        <button-primary href="/" text="Read More"></button-primary>
                    </div>
                </div>
                <div class="right">
                    ${this.elements.map(e=>this.renderElement(e))}
                </div>
            </section>
        `}}customElements.define("mobile-development-section",ze);class Oe extends d{static styles=[f,h`
        .container {
            display: flex;
            flex-direction: column;
            margin-bottom: 2em;
        }

        .top {
            display: flex;
            width: var(--width-content);
            margin: 0 auto;
            gap: 3em;
        }

        .left {
            display: flex;
            flex-direction: column;
            flex: 3;
            align-items: flex-start;
            gap: 2em;
        }

        .title {
            font-size: clamp(3rem, 1vw + 3.5rem, 5rem);
            line-height: 1.1;
            font-weight: 500;
        }

        .right {
            flex: 2;
            display: flex;
            flex-direction: column;
            font-size: clamp(1rem, 0.55vw + 0.55rem, 2rem);
            justify-content: flex-end;
            line-height: 1.75;
        }

        .content {
            height: 40vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    `];render(){return l`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="Nativeness"></subtitle-component>
                        <h1 class="title">
                            Familiar PHP. Now for desktop and mobile applications.
                        </h1>
                    </div>
                    <div class="right">
                        <p>"What makes you think PHP is only for the web?"</p>
                        <p>– Boson is changing the rules of the game!</p>
                    </div>
                </div>
                <div class="content">
                    TODO
                </div>
            </section>
        `}}customElements.define("nativeness-section",Oe);class Me extends d{static styles=[f,h`
        .container {
            background-size: 100% auto;
            background: url("/images/right_choice_bg.png") no-repeat top;
            height: 200vh;
        }

        .top {
            margin: 6em;
            display: flex;
            font-size: max(4rem, min(4.5rem + 1vw, 7rem));
            line-height: 1.1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .red {
            color: var(--color-text-brand);
        }

        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    `];render(){return l`
            <section class="container">
                <div class="top">
                    <h1>Why is Boson PHP</h1>
                    <h1 class="red">the right choice</h1>
                    <h1>for you?</h1>
                </div>
                <div class="content">
                    TODO
                </div>
            </section>
        `}}customElements.define("right-choice-section",Me);class Ne extends d{static styles=[f,h`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            width: var(--width-content);
            margin: 0 auto;
        }

        .left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2em;
        }

        .text h1 {
            font-size: max(3rem, min(1vw + 3.5rem, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }

        .red {
            color: var(--color-text-brand);
        }

        .right {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            max-width: clamp(650px, 40vw, 800px);
            gap: 1em;
        }

        .el {
            display: flex;
            gap: 1em;
            align-items: flex-start;
        }

        .el p {
            transform: translateY(-6px);
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }

        .content {
            display: flex;
            padding: 1px 0;
            border-bottom: 1px solid var(--color-border);
            border-top: 1px solid var(--color-border);
        }

        .dots {
            min-width: 120px;
        }

        .content .dots:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .inner {
            display: flex;
            flex: 1;
        }

        .solves {
            border-right: 1px solid var(--color-border);
            padding: 4em;
            gap: 1.25em;
            display: flex;
            line-height: 1.75;
            flex-direction: column;
        }

        .solves img {
            align-self: flex-start;
        }

        .solves h2 {
            font-weight: 500;
        }
    `];render(){return l`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="Solves"></subtitle-component>
                        <div class="text">
                            <h1>What <span class="red">you can</span> do</h1>
                            <h1>with Boson?</h1>
                        </div>
                    </div>
                    <div class="right">
                        <div class="el">
                            <img src="/images/icons/check.svg" alt="check"/>
                            <p>Compile an application for the desired desktop platform based on an existing PHP
                                project.</p>
                        </div>
                        <div class="el">
                            <img src="/images/icons/check.svg" alt="check"/>
                            <p>Create a mobile app. Expand your business and reach a new target audience.</p>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <div class="inner">
                        <div class="solves">
                            <img src="/images/icons/terminal.svg" alt="terminal"/>
                            <h2>For developers</h2>
                            <p>Pride in your favorite language, which is not dying! A real desire to create something
                                useful and interesting. Boson will allow you to create applications from scratch, as a
                                framework.</p>
                        </div>
                        <div class="solves">
                            <img src="/images/icons/lock.svg" alt="lock"/>
                            <h2>For business</h2>
                            <p>Desktop application – getting different variants of working applications. Mobile
                                application – expand profits by getting a new segment of the mobile application
                                market.</p>
                        </div>
                        <div class="solves">
                            <img src="/images/icons/web.svg" alt="web"/>
                            <h2>For web studios</h2>
                            <p>No need to expand your staff to make applications for different platforms, work with
                                Bosob and increase your income.</p>
                        </div>
                    </div>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                </div>
            </section>
        `}}customElements.define("solves-section",Ne);class Ue extends d{static styles=[f,h`
        .container {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6em;
        }

        .top {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3em;
        }

        .headline {
            text-align: center;
        }

        .headline h1 {
            font-size: max(3rem, min(3.5rem + 1vw, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }

        .container:before {
            content: '';
            position: absolute;
            pointer-events: none;
            background: radial-gradient(50% 50% at 50% 50%, #F93904 0%, #0A0A0A 50%);
            opacity: 0.3;
            inset: 0;
            filter: blur(140px);
            z-index: -1;
        }
    `];get slides(){return[{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building irst meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev4",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."}]}render(){return l`
            <section class="container">
                <div class="top">
                    <subtitle-component name="Testimonials"></subtitle-component>
                    <div class="headline">
                        <h1>Developers that</h1>
                        <h1>believe in us</h1>
                    </div>
                </div>
                <div class="content">
                    <slider-component .slides=${this.slides}></slider-component>
                </div>
            </section>
        `}}customElements.define("testimonials-section",Ue);class je extends d{static properties={isScrolled:{type:Boolean}};static styles=[h`
        .container {
            height: 100px;
            line-height: 100px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--color-border);
            transition-duration: 0.2s;
            background: var(--color-bg-opacity);
            backdrop-filter: blur(14px);
            z-index: 10;
        }

        .container.scrolled {
            height: 70px;
            line-height: 70px;
        }

        .header-padding {
            width: 100%;
            height: 100px;
        }

        .dots,
        ::slotted(*) {
            height: 100%;
        }

        .dots:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .nav {
            flex: 1;
            padding: 0 3em;
            display: flex;
            gap: 3em;
            border-right: 1px solid var(--color-border);
            align-self: stretch;
            align-items: center;
        }
    `];constructor(){super(),this.isScrolled=!1,this.onScroll=this.onScroll.bind(this)}connectedCallback(){super.connectedCallback(),window.addEventListener("scroll",this.onScroll),this.onScroll()}disconnectedCallback(){super.disconnectedCallback(),window.removeEventListener("scroll",this.onScroll)}onScroll(){const e=window.pageYOffset||document.documentElement.scrollTop;this.isScrolled=e>30}render(){return l`
            <header class="container ${this.isScrolled?"scrolled":""}">
                <div class="dots">
                    <dots-container></dots-container>
                </div>

                <slot name="logo"></slot>

                <div class="nav">
                    <slot></slot>
                </div>

                <slot name="aside"></slot>

                <div class="dots">
                    <dots-container></dots-container>
                </div>
            </header>
            <div class="header-padding"></div>
        `}}customElements.define("boson-header",je);class Ie extends d{static properties={href:{type:String},external:{type:Boolean}};static styles=[f,h`
        .button {
            height: inherit;
            border-right: 1px solid var(--color-border);
            padding: 0 3em;
            display: flex;
            align-items: center;
            transition: background .2s ease;
            text-transform: uppercase;
            gap: 0.75em;
        }

        .button:hover {
            background: var(--color-bg-hover);
        }

        ::slotted(img.logo) {
            height: 50%;
        }
    `];constructor(){super(),this.href="/",this.external=!1}render(){return l`
            <a class="button"
               href="${this.href}"
               target="${this.external?"_blank":"_self"}">
                <slot></slot>
            </a>
        `}}customElements.define("boson-header-button",Ie);class Re extends d{static properties={};static styles=[f,h`
        details > summary {
            list-style-type: '';
        }

        details > summary::-webkit-details-marker,
        details > summary::marker {
            display: none;
        }

        .dropdown {
            position: relative;
            padding-right: 20px;
        }

        .dropdown:hover .dropdown-summary::after {
            transform: rotate(45deg);
        }

        .dropdown-summary {
            position: relative;
        }

        .dropdown-summary::after {
            content: '';
            width: 3px;
            height: 3px;
            display: block;
            border: solid 2px var(--color-text-brand);
            border-right-color: transparent;
            border-bottom-color: transparent;
            transition: .2s ease;
            border-radius: 1px;
            position: absolute;
            top: 50%;
            right: -20px;
            margin-top: -2.2px;
            transform-origin: 2px 2px;
            transform: rotate(225deg);
        }

        .dropdown-list {
            position: absolute;
            line-height: 42px;
            background: var(--color-bg-layer);
            border: 1px solid var(--color-border);
            padding: 10px 20px;
            display: flex;
            min-width: 200px;
            flex-direction: column;
            flex-wrap: nowrap;
            top: 50%;
            margin-top: 15px;
        }

        ::slotted(*) {
            white-space: nowrap;
        }

        ::slotted(strong) {
            text-transform: uppercase;
            color: var(--color-text-secondary);
            font-size: 90%;
        }
    `];constructor(){super()}onMouseEnter(e){e.target.setAttribute("open","open")}onMouseLeave(e){e.target.removeAttribute("open")}render(){return l`
            <details class="dropdown"
                     @mouseenter="${this.onMouseEnter}"
                     @mouseleave="${this.onMouseLeave}">

                <summary class="dropdown-summary">
                    <slot name="summary"></slot>
                </summary>

                <nav class="dropdown-list">
                    <slot></slot>
                </nav>
            </details>
        `}}customElements.define("boson-header-dropdown",Re);class We extends d{static properties={href:{type:String},external:{type:Boolean},active:{type:Boolean}};static styles=[f,h`
        .link {
            color: var(--color-text-secondary);
            transition-duration: 0.2s;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .link.active,
        .link:hover {
            color: var(--color-text-brand);
        }

        ::slotted(img) {
            margin-right: 15px;
        }
    `];constructor(){super(),this.href="/",this.external=!1,this.active=!1}render(){return l`
            <a class="link ${this.active?"active":""}"
               href="${this.href}"
               target="${this.external?"_blank":"_self"}">
                <slot></slot>
            </a>
        `}}customElements.define("boson-header-link",We);class De extends d{static properties={};static styles=[h`
        .breadcrumbs {
            height: 50px;
            line-height: 50px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-content: center;
            border-bottom: 1px solid var(--color-border);
            border-top: 1px solid var(--color-border);
            transition-duration: 0.2s;
            background: var(--color-bg-opacity);
            backdrop-filter: blur(14px);
            z-index: 10;
        }

        .breadcrumbs::before,
        .breadcrumbs::after {
            content: '';
            display: block;
            width: 100px;
            height: 100%;
        }

        .breadcrumbs::before {
            border-right: 1px solid var(--color-border);
        }

        .breadcrumbs::after {
            border-left: 1px solid var(--color-border);
        }

        .breadcrumbs-items {
            display: flex;
            flex-wrap: nowrap;
            align-content: center;
            flex: 1;
        }

        ::slotted(*) {
            display: flex;
            align-items: center;
            height: 100%;
            position: relative;
            padding: 0 30px 0 55px;
            transition: background .2s ease;
        }

        ::slotted(*:first-child) {
            padding-left: 40px;
        }

        ::slotted(*)::before,
        ::slotted(*)::after {
            top: -2px;
            content: '';
            width: 0;
            border-radius: 6px;
            right: -50px;
            position: absolute;
            aspect-ratio: 1 / 1;
            border: solid 27px transparent;
            border-left-color: var(--color-bg);
            z-index: 2;
            transition: border-left-color .2s ease;
        }

        ::slotted(*)::before {
            right: -52px;
            border-radius: 2px;
            border-left-color: var(--color-border);
        }

        ::slotted(*:last-child)::after,
        ::slotted(*:last-child)::before {
          display: none;
        }

        ::slotted(*:not(:last-child):hover) {
            background: var(--color-bg-hover);
        }

        ::slotted(*:not(:last-child):hover)::after {
            border-left-color: var(--color-bg-hover);
        }
    `];constructor(){super()}render(){return l`
            <nav class="breadcrumbs">
                <div class="breadcrumbs-items">

                    <slot></slot>

                </div>
            </nav>
        `}}customElements.define("boson-breadcrumbs",De);class Le extends d{static styles=[f,h`
        .container {
            aspect-ratio: 1 / 1;
            position: relative;
            height: 100%;
            width: 100%;
        }

        .inner {
            inset: 1em;
            position: absolute;
        }

        .inner > div {
            height: 5px;
            width: 5px;
            position: absolute;
            background: url("/images/icons/dot.svg");
        }

        .top {
            top: 0;
        }

        .bottom {
            bottom: 0;
        }

        .left {
            left: 0;
        }

        .right {
            right: 0;
        }
    `];render(){return l`
            <div class="container">
                <div class="inner">
                    <div class="top left"></div>
                    <div class="top right"></div>
                    <div class="bottom left"></div>
                    <div class="bottom right"></div>
                </div>
            </div>
        `}}customElements.define("dots-container",Le);class Ve extends d{static styles=[h`
        .container {
            display: flex;
            flex-direction: column;
        }

        .content {
            border-top: 1px solid var(--color-border);
            border-bottom: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .top {
            display: flex;
            border-bottom: 1px solid var(--color-border);
        }

        .bottom {
            display: flex;
        }

        .dots-left, .dots-right {
            min-width: 120px;
            max-width: 120px;
            position: absolute;
            top: 0;
            bottom: 0;
        }

        .dots-left {
            left: 0;
        }

        .dots-right {
            right: 0;
        }

        .holder {
            min-width: 120px;
            max-width: 120px;
        }

        .holder:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        ::slotted(a) {
            padding: 3.5em 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 230px;
            border-right: 1px solid var(--color-border);
            transition-duration: 0.2s;
        }

        ::slotted(a:hover) {
            background: var(--color-bg-hover);
        }

        [name="secondary-link"]::slotted(a) {
            color: var(--color-text-secondary) !important;
        }

        [name="secondary-link"]::slotted(a:hover) {
            background: var(--color-bg-hover) !important;
        }

        .dots-main {
            flex: 1;
            border-right: 1px solid var(--color-border);
            padding: 1em;
        }

        .dots-inner {
            height: 100%;
            width: 100%;
            background: url("/images/icons/dots.svg");
            background-size: cover;
        }

        .copyright {
            flex: 1;
            border-right: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            margin-left: 3em;
            font-size: max(1rem, min(.55rem + .55vw, 2rem));
            line-height: 1.75;
            color: var(--color-text-secondary);
        }

        .credits {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2em;
        }

        .credits img {
            height: 24px;
        }
    `];render(){return l`
            <footer class="container">
                <div class="content">
                    <div class="top">
                        <div class="holder"></div>

                        <slot name="main-link"></slot>

                        <div class="dots-main">
                            <div class="dots-inner"></div>
                        </div>

                        <slot name="aside-link"></slot>

                        <div class="holder"></div>
                    </div>

                    <div class="bottom">
                        <div class="holder"></div>

                        <div class="copyright">
                            <slot name="copyright"></slot>
                        </div>

                        <slot name="secondary-link"></slot>

                        <div class="holder"></div>
                    </div>

                    <div class="dots-left">
                        <dots-container></dots-container>
                    </div>

                    <div class="dots-right">
                        <dots-container></dots-container>
                    </div>
                </div>
                <div class="credits">
                    <img src="/images/credits.png" alt="credits"/>
                </div>
            </footer>
        `}}customElements.define("boson-footer",Ve);class qe extends d{static properties={content:{type:Array},openIndex:{type:Number}};static styles=[f,h`
        .accordion {
            display: flex;
            height: 24rem;
            flex: 1;
        }

        .element {
            border-right: 1px solid var(--color-border);
            transition-duration: 0.3s;
        }

        .elementOpen {
            flex: 1;
        }

        .elementClosed {
            width: 5em;
            cursor: pointer;
        }

        .elementClosed:hover {
            background: var(--color-bg-hover);
        }

        .elementOpen .elementContent {
            padding: 2em 3em;
        }

        .elementClosed .elementContent {
            padding: 2em 0;
        }

        .elementContent {
            transition-duration: 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .openTop {
            display: flex;
            align-items: center;
            gap: 3em;
            animation: appear 1s forwards;
            height: 60px;
        }

        .closedTop {
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            flex: 1;
            width: 700px;
            animation: appear 1s forwards;
            margin-left: 4.5em;
            display: flex;
            align-items: flex-end;
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }

        .headline {
            font-size: max(1.5rem, min(2rem + 1vw, 2.25rem));
            font-weight: 500;
        }

        .number {
            font-size: max(1.5rem, min(2rem + 1vw, 2rem));
            color: var(--color-text-brand);
            transition-duration: 0.2s;
        }

        .elementClosed .elementContent .closedTop .number {
            color: var(--color-text-secondary);
        }

        .elementClosed:hover .elementContent .closedTop .number {
            color: var(--color-text-brand);
        }

        .collapsedContent {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            filter: grayscale(100%);
            transition-duration: 0.2s;
        }

        .elementClosed:hover .elementContent .collapsedContent {
            filter: grayscale(0%);
        }

        @keyframes appear {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    `];constructor(){super(),this.content=[],this.openIndex=0}handleElementClick(e){this.openIndex=e}renderElement(e,t){const i=this.openIndex===t;return l`
            <div
                class="element ${i?"elementOpen":"elementClosed"}"
                @click=${()=>this.handleElementClick(t)}
            >
                <div class="elementContent">
                    ${i?l`
                        <div class="openTop">
                            <span class="number">0${t+1}</span>
                            <h3 class="headline">${e.headline}</h3>
                        </div>
                    `:l`
                        <div class="closedTop">
                            <span class="number">0${t+1}</span>
                        </div>
                    `}

                    ${i?l`
                        <div class="content">
                            <p class="text">${e.text}</p>
                        </div>
                    `:l`
                        <div class="collapsedContent">
                            <img src="/images/icons/plus.svg" alt="plus"/>
                        </div>
                    `}
                </div>
            </div>
        `}render(){return l`
            <div class="accordion">
                ${this.content.map((e,t)=>this.renderElement(e,t))}
            </div>
        `}}customElements.define("horizontal-accordion",qe);class Fe extends d{static properties={slides:{type:Array},currentIndex:{type:Number},slidesPerView:{type:Number}};static styles=[f,h`
        .container {
            display: flex;
            max-width: 100vw;
            overflow: hidden;
            border-top: 1px solid var(--color-border);
            border-bottom: 1px solid var(--color-border);
            background: var(--color-bg);
        }

        .sliderContent {
            width: calc(100vw - 240px - 12px);
            overflow: hidden;
        }

        .sliderButton {
            all: unset;
            min-width: 120px;
            max-width: 120px;
            cursor: pointer;
            position: relative;
            transition-duration: 0.2s;
            display: flex;
            flex-direction: column;
            text-transform: uppercase;
            gap: 0.5em;
            justify-content: center;
            align-items: center;
        }

        .sliderButton:hover {
            background-color: var(--color-bg-hover);
        }

        .sliderButton:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .sliderButton:nth-last-child(1) {
            border-left: 1px solid var(--color-border);
        }

        .dots {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .slidesWrapper {
            display: flex;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .slideWrapper {
            flex: none;
            cursor: grab;
        }

        .slide {
            padding: 3em;
            border-right: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            gap: 2em;
            height: 100%;
            min-height: 400px;
        }

        .quote {
            align-self: flex-start;
        }

        .comment {
            font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
            line-height: 1.75;
        }

        .bottom {
            margin-top: auto;
            display: flex;
            gap: 1em;
        }

        .pfp {
            height: 52px;
            width: 52px;
        }

        .info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.25em;
        }

        .name {
            font-weight: 500;
        }

        .role {
            color: var(--color-text-brand);
            text-transform: uppercase;
        }

        @media (min-width: 768px) {
            .slideWrapper {
                width: calc(100% / 3);
            }
        }

        @media (max-width: 767px) {
            .slideWrapper {
                width: 100%;
            }
        }
    `];constructor(){super(),this.slides=[],this.currentIndex=0,this.slidesPerView=1,this.autoplayInterval=null}connectedCallback(){super.connectedCallback(),this.updateSlidesPerView(),this.startAutoplay(),window.addEventListener("resize",this.updateSlidesPerView.bind(this))}disconnectedCallback(){super.disconnectedCallback(),this.stopAutoplay(),window.removeEventListener("resize",this.updateSlidesPerView.bind(this))}updateSlidesPerView(){this.slidesPerView=window.innerWidth>=768?3:1,this.requestUpdate()}startAutoplay(){this.stopAutoplay(),this.autoplayInterval=setInterval(()=>{this.slideNext()},3e3)}stopAutoplay(){this.autoplayInterval&&(clearInterval(this.autoplayInterval),this.autoplayInterval=null)}slidePrev(){this.currentIndex=this.currentIndex<=0?this.slides.length-this.slidesPerView:this.currentIndex-1,this.requestUpdate()}slideNext(){this.currentIndex=this.currentIndex>=this.slides.length-this.slidesPerView?0:this.currentIndex+1,this.requestUpdate()}getTransform(){const e=100/this.slidesPerView;return`translateX(-${this.currentIndex*e}%)`}renderSlide(e,t){return l`
            <div class="slideWrapper">
                <div class="slide">
                    <img class="quote" src="/images/icons/quote.svg" alt="quote"/>
                    <p class="comment">"${e.comment}"</p>
                    <div class="bottom">
                        <img class="pfp" src="/images/${e.pfp}" alt="${e.name}"/>
                        <div class="info">
                            <h3 class="name">${e.name}</h3>
                            <p class="role">${e.role}</p>
                        </div>
                    </div>
                </div>
            </div>
        `}render(){return l`
            <div class="container">
                <button class="sliderButton" @click=${this.slidePrev}>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <img src="/images/icons/red_arrow_left.svg" alt="prev"/>
                    <span>Prev</span>
                </button>
                <div class="sliderContent">
                    <div class="slidesWrapper" style="transform: ${this.getTransform()}">
                        ${this.slides.map((e,t)=>this.renderSlide(e,t))}
                    </div>
                </div>
                <button class="sliderButton" @click=${this.slideNext}>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <img src="/images/icons/red_arrow_right.svg" alt="next"/>
                    <span>Next</span>
                </button>
            </div>
        `}}customElements.define("slider-component",Fe);class Ye extends d{static properties={name:{type:String}};static styles=[f,h`
        .container {
            display: flex;
            gap: 1em;
            justify-content: center;
            align-items: center;
        }

        .name {
            text-transform: uppercase;
        }
    `];constructor(){super(),this.name=""}render(){return l`
            <div class="container">
                <img class="img" src="/images/icons/subtitle.svg" alt="subtitle"/>
                <span class="name">${this.name}</span>
            </div>
        `}}customElements.define("subtitle-component",Ye);class Ke extends d{static styles=[h`
        .landing-layout {
            display: flex;
            flex-direction: column;
            gap: 8em;
        }
    `];render(){return l`
            <main class="landing-layout">
                <slot></slot>
            </main>
        `}}customElements.define("boson-landing-layout",Ke);
