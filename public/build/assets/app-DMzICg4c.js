/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const O=globalThis,I=O.ShadowRoot&&(O.ShadyCSS===void 0||O.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,R=Symbol(),V=new WeakMap;let ee=class{constructor(e,t,i){if(this._$cssResult$=!0,i!==R)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=e,this.t=t}get styleSheet(){let e=this.o;const t=this.t;if(I&&e===void 0){const i=t!==void 0&&t.length===1;i&&(e=V.get(t)),e===void 0&&((this.o=e=new CSSStyleSheet).replaceSync(this.cssText),i&&V.set(t,e))}return e}toString(){return this.cssText}};const re=n=>new ee(typeof n=="string"?n:n+"",void 0,R),h=(n,...e)=>{const t=n.length===1?n[0]:e.reduce((i,s,o)=>i+(r=>{if(r._$cssResult$===!0)return r.cssText;if(typeof r=="number")return r;throw Error("Value passed to 'css' function must be a 'css' function result: "+r+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+n[o+1],n[0]);return new ee(t,n,R)},ae=(n,e)=>{if(I)n.adoptedStyleSheets=e.map(t=>t instanceof CSSStyleSheet?t:t.styleSheet);else for(const t of e){const i=document.createElement("style"),s=O.litNonce;s!==void 0&&i.setAttribute("nonce",s),i.textContent=t.cssText,n.appendChild(i)}},q=I?n=>n:n=>n instanceof CSSStyleSheet?(e=>{let t="";for(const i of e.cssRules)t+=i.cssText;return re(t)})(n):n;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:le,defineProperty:de,getOwnPropertyDescriptor:ce,getOwnPropertyNames:he,getOwnPropertySymbols:pe,getPrototypeOf:me}=Object,M=globalThis,F=M.trustedTypes,ue=F?F.emptyScript:"",ge=M.reactiveElementPolyfillSupport,P=(n,e)=>n,j={toAttribute(n,e){switch(e){case Boolean:n=n?ue:null;break;case Object:case Array:n=n==null?n:JSON.stringify(n)}return n},fromAttribute(n,e){let t=n;switch(e){case Boolean:t=n!==null;break;case Number:t=n===null?null:Number(n);break;case Object:case Array:try{t=JSON.parse(n)}catch{t=null}}return t}},te=(n,e)=>!le(n,e),Y={attribute:!0,type:String,converter:j,reflect:!1,useDefault:!1,hasChanged:te};Symbol.metadata??=Symbol("metadata"),M.litPropertyMetadata??=new WeakMap;let _=class extends HTMLElement{static addInitializer(e){this._$Ei(),(this.l??=[]).push(e)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(e,t=Y){if(t.state&&(t.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(e)&&((t=Object.create(t)).wrapped=!0),this.elementProperties.set(e,t),!t.noAccessor){const i=Symbol(),s=this.getPropertyDescriptor(e,i,t);s!==void 0&&de(this.prototype,e,s)}}static getPropertyDescriptor(e,t,i){const{get:s,set:o}=ce(this.prototype,e)??{get(){return this[t]},set(r){this[t]=r}};return{get:s,set(r){const p=s?.call(this);o?.call(this,r),this.requestUpdate(e,p,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(e){return this.elementProperties.get(e)??Y}static _$Ei(){if(this.hasOwnProperty(P("elementProperties")))return;const e=me(this);e.finalize(),e.l!==void 0&&(this.l=[...e.l]),this.elementProperties=new Map(e.elementProperties)}static finalize(){if(this.hasOwnProperty(P("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(P("properties"))){const t=this.properties,i=[...he(t),...pe(t)];for(const s of i)this.createProperty(s,t[s])}const e=this[Symbol.metadata];if(e!==null){const t=litPropertyMetadata.get(e);if(t!==void 0)for(const[i,s]of t)this.elementProperties.set(i,s)}this._$Eh=new Map;for(const[t,i]of this.elementProperties){const s=this._$Eu(t,i);s!==void 0&&this._$Eh.set(s,t)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(e){const t=[];if(Array.isArray(e)){const i=new Set(e.flat(1/0).reverse());for(const s of i)t.unshift(q(s))}else e!==void 0&&t.push(q(e));return t}static _$Eu(e,t){const i=t.attribute;return i===!1?void 0:typeof i=="string"?i:typeof e=="string"?e.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),this.constructor.l?.forEach(e=>e(this))}addController(e){(this._$EO??=new Set).add(e),this.renderRoot!==void 0&&this.isConnected&&e.hostConnected?.()}removeController(e){this._$EO?.delete(e)}_$E_(){const e=new Map,t=this.constructor.elementProperties;for(const i of t.keys())this.hasOwnProperty(i)&&(e.set(i,this[i]),delete this[i]);e.size>0&&(this._$Ep=e)}createRenderRoot(){const e=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return ae(e,this.constructor.elementStyles),e}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$EO?.forEach(e=>e.hostConnected?.())}enableUpdating(e){}disconnectedCallback(){this._$EO?.forEach(e=>e.hostDisconnected?.())}attributeChangedCallback(e,t,i){this._$AK(e,i)}_$ET(e,t){const i=this.constructor.elementProperties.get(e),s=this.constructor._$Eu(e,i);if(s!==void 0&&i.reflect===!0){const o=(i.converter?.toAttribute!==void 0?i.converter:j).toAttribute(t,i.type);this._$Em=e,o==null?this.removeAttribute(s):this.setAttribute(s,o),this._$Em=null}}_$AK(e,t){const i=this.constructor,s=i._$Eh.get(e);if(s!==void 0&&this._$Em!==s){const o=i.getPropertyOptions(s),r=typeof o.converter=="function"?{fromAttribute:o.converter}:o.converter?.fromAttribute!==void 0?o.converter:j;this._$Em=s;const p=r.fromAttribute(t,o.type);this[s]=p??this._$Ej?.get(s)??p,this._$Em=null}}requestUpdate(e,t,i){if(e!==void 0){const s=this.constructor,o=this[e];if(i??=s.getPropertyOptions(e),!((i.hasChanged??te)(o,t)||i.useDefault&&i.reflect&&o===this._$Ej?.get(e)&&!this.hasAttribute(s._$Eu(e,i))))return;this.C(e,t,i)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(e,t,{useDefault:i,reflect:s,wrapped:o},r){i&&!(this._$Ej??=new Map).has(e)&&(this._$Ej.set(e,r??t??this[e]),o!==!0||r!==void 0)||(this._$AL.has(e)||(this.hasUpdated||i||(t=void 0),this._$AL.set(e,t)),s===!0&&this._$Em!==e&&(this._$Eq??=new Set).add(e))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(t){Promise.reject(t)}const e=this.scheduleUpdate();return e!=null&&await e,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[s,o]of this._$Ep)this[s]=o;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[s,o]of i){const{wrapped:r}=o,p=this[s];r!==!0||this._$AL.has(s)||p===void 0||this.C(s,void 0,o,p)}}let e=!1;const t=this._$AL;try{e=this.shouldUpdate(t),e?(this.willUpdate(t),this._$EO?.forEach(i=>i.hostUpdate?.()),this.update(t)):this._$EM()}catch(i){throw e=!1,this._$EM(),i}e&&this._$AE(t)}willUpdate(e){}_$AE(e){this._$EO?.forEach(t=>t.hostUpdated?.()),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(e)),this.updated(e)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(e){return!0}update(e){this._$Eq&&=this._$Eq.forEach(t=>this._$ET(t,this[t])),this._$EM()}updated(e){}firstUpdated(e){}};_.elementStyles=[],_.shadowRootOptions={mode:"open"},_[P("elementProperties")]=new Map,_[P("finalized")]=new Map,ge?.({ReactiveElement:_}),(M.reactiveElementVersions??=[]).push("2.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const W=globalThis,z=W.trustedTypes,K=z?z.createPolicy("lit-html",{createHTML:n=>n}):void 0,ie="$lit$",y=`lit$${Math.random().toFixed(9).slice(2)}$`,se="?"+y,fe=`<${se}>`,w=document,k=()=>w.createComment(""),C=n=>n===null||typeof n!="object"&&typeof n!="function",D=Array.isArray,ve=n=>D(n)||typeof n?.[Symbol.iterator]=="function",U=`[ 	
\f\r]`,S=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,G=/-->/g,J=/>/g,b=RegExp(`>|${U}(?:([^\\s"'>=/]+)(${U}*=${U}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),Z=/'/g,X=/"/g,ne=/^(?:script|style|textarea|title)$/i,xe=n=>(e,...t)=>({_$litType$:n,strings:e,values:t}),l=xe(1),A=Symbol.for("lit-noChange"),u=Symbol.for("lit-nothing"),Q=new WeakMap,$=w.createTreeWalker(w,129);function oe(n,e){if(!D(n)||!n.hasOwnProperty("raw"))throw Error("invalid template strings array");return K!==void 0?K.createHTML(e):e}const ye=(n,e)=>{const t=n.length-1,i=[];let s,o=e===2?"<svg>":e===3?"<math>":"",r=S;for(let p=0;p<t;p++){const a=n[p];let m,f,d=-1,v=0;for(;v<a.length&&(r.lastIndex=v,f=r.exec(a),f!==null);)v=r.lastIndex,r===S?f[1]==="!--"?r=G:f[1]!==void 0?r=J:f[2]!==void 0?(ne.test(f[2])&&(s=RegExp("</"+f[2],"g")),r=b):f[3]!==void 0&&(r=b):r===b?f[0]===">"?(r=s??S,d=-1):f[1]===void 0?d=-2:(d=r.lastIndex-f[2].length,m=f[1],r=f[3]===void 0?b:f[3]==='"'?X:Z):r===X||r===Z?r=b:r===G||r===J?r=S:(r=b,s=void 0);const x=r===b&&n[p+1].startsWith("/>")?" ":"";o+=r===S?a+fe:d>=0?(i.push(m),a.slice(0,d)+ie+a.slice(d)+y+x):a+y+(d===-2?p:x)}return[oe(n,o+(n[t]||"<?>")+(e===2?"</svg>":e===3?"</math>":"")),i]};class H{constructor({strings:e,_$litType$:t},i){let s;this.parts=[];let o=0,r=0;const p=e.length-1,a=this.parts,[m,f]=ye(e,t);if(this.el=H.createElement(m,i),$.currentNode=this.el.content,t===2||t===3){const d=this.el.content.firstChild;d.replaceWith(...d.childNodes)}for(;(s=$.nextNode())!==null&&a.length<p;){if(s.nodeType===1){if(s.hasAttributes())for(const d of s.getAttributeNames())if(d.endsWith(ie)){const v=f[r++],x=s.getAttribute(d).split(y),T=/([.?@])?(.*)/.exec(v);a.push({type:1,index:o,name:T[2],strings:x,ctor:T[1]==="."?$e:T[1]==="?"?we:T[1]==="@"?_e:N}),s.removeAttribute(d)}else d.startsWith(y)&&(a.push({type:6,index:o}),s.removeAttribute(d));if(ne.test(s.tagName)){const d=s.textContent.split(y),v=d.length-1;if(v>0){s.textContent=z?z.emptyScript:"";for(let x=0;x<v;x++)s.append(d[x],k()),$.nextNode(),a.push({type:2,index:++o});s.append(d[v],k())}}}else if(s.nodeType===8)if(s.data===se)a.push({type:2,index:o});else{let d=-1;for(;(d=s.data.indexOf(y,d+1))!==-1;)a.push({type:7,index:o}),d+=y.length-1}o++}}static createElement(e,t){const i=w.createElement("template");return i.innerHTML=e,i}}function E(n,e,t=n,i){if(e===A)return e;let s=i!==void 0?t._$Co?.[i]:t._$Cl;const o=C(e)?void 0:e._$litDirective$;return s?.constructor!==o&&(s?._$AO?.(!1),o===void 0?s=void 0:(s=new o(n),s._$AT(n,t,i)),i!==void 0?(t._$Co??=[])[i]=s:t._$Cl=s),s!==void 0&&(e=E(n,s._$AS(n,e.values),s,i)),e}class be{constructor(e,t){this._$AV=[],this._$AN=void 0,this._$AD=e,this._$AM=t}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(e){const{el:{content:t},parts:i}=this._$AD,s=(e?.creationScope??w).importNode(t,!0);$.currentNode=s;let o=$.nextNode(),r=0,p=0,a=i[0];for(;a!==void 0;){if(r===a.index){let m;a.type===2?m=new B(o,o.nextSibling,this,e):a.type===1?m=new a.ctor(o,a.name,a.strings,this,e):a.type===6&&(m=new Ae(o,this,e)),this._$AV.push(m),a=i[++p]}r!==a?.index&&(o=$.nextNode(),r++)}return $.currentNode=w,s}p(e){let t=0;for(const i of this._$AV)i!==void 0&&(i.strings!==void 0?(i._$AI(e,i,t),t+=i.strings.length-2):i._$AI(e[t])),t++}}class B{get _$AU(){return this._$AM?._$AU??this._$Cv}constructor(e,t,i,s){this.type=2,this._$AH=u,this._$AN=void 0,this._$AA=e,this._$AB=t,this._$AM=i,this.options=s,this._$Cv=s?.isConnected??!0}get parentNode(){let e=this._$AA.parentNode;const t=this._$AM;return t!==void 0&&e?.nodeType===11&&(e=t.parentNode),e}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(e,t=this){e=E(this,e,t),C(e)?e===u||e==null||e===""?(this._$AH!==u&&this._$AR(),this._$AH=u):e!==this._$AH&&e!==A&&this._(e):e._$litType$!==void 0?this.$(e):e.nodeType!==void 0?this.T(e):ve(e)?this.k(e):this._(e)}O(e){return this._$AA.parentNode.insertBefore(e,this._$AB)}T(e){this._$AH!==e&&(this._$AR(),this._$AH=this.O(e))}_(e){this._$AH!==u&&C(this._$AH)?this._$AA.nextSibling.data=e:this.T(w.createTextNode(e)),this._$AH=e}$(e){const{values:t,_$litType$:i}=e,s=typeof i=="number"?this._$AC(e):(i.el===void 0&&(i.el=H.createElement(oe(i.h,i.h[0]),this.options)),i);if(this._$AH?._$AD===s)this._$AH.p(t);else{const o=new be(s,this),r=o.u(this.options);o.p(t),this.T(r),this._$AH=o}}_$AC(e){let t=Q.get(e.strings);return t===void 0&&Q.set(e.strings,t=new H(e)),t}k(e){D(this._$AH)||(this._$AH=[],this._$AR());const t=this._$AH;let i,s=0;for(const o of e)s===t.length?t.push(i=new B(this.O(k()),this.O(k()),this,this.options)):i=t[s],i._$AI(o),s++;s<t.length&&(this._$AR(i&&i._$AB.nextSibling,s),t.length=s)}_$AR(e=this._$AA.nextSibling,t){for(this._$AP?.(!1,!0,t);e!==this._$AB;){const i=e.nextSibling;e.remove(),e=i}}setConnected(e){this._$AM===void 0&&(this._$Cv=e,this._$AP?.(e))}}class N{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(e,t,i,s,o){this.type=1,this._$AH=u,this._$AN=void 0,this.element=e,this.name=t,this._$AM=s,this.options=o,i.length>2||i[0]!==""||i[1]!==""?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=u}_$AI(e,t=this,i,s){const o=this.strings;let r=!1;if(o===void 0)e=E(this,e,t,0),r=!C(e)||e!==this._$AH&&e!==A,r&&(this._$AH=e);else{const p=e;let a,m;for(e=o[0],a=0;a<o.length-1;a++)m=E(this,p[i+a],t,a),m===A&&(m=this._$AH[a]),r||=!C(m)||m!==this._$AH[a],m===u?e=u:e!==u&&(e+=(m??"")+o[a+1]),this._$AH[a]=m}r&&!s&&this.j(e)}j(e){e===u?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,e??"")}}class $e extends N{constructor(){super(...arguments),this.type=3}j(e){this.element[this.name]=e===u?void 0:e}}class we extends N{constructor(){super(...arguments),this.type=4}j(e){this.element.toggleAttribute(this.name,!!e&&e!==u)}}class _e extends N{constructor(e,t,i,s,o){super(e,t,i,s,o),this.type=5}_$AI(e,t=this){if((e=E(this,e,t,0)??u)===A)return;const i=this._$AH,s=e===u&&i!==u||e.capture!==i.capture||e.once!==i.once||e.passive!==i.passive,o=e!==u&&(i===u||s);s&&this.element.removeEventListener(this.name,this,i),o&&this.element.addEventListener(this.name,this,e),this._$AH=e}handleEvent(e){typeof this._$AH=="function"?this._$AH.call(this.options?.host??this.element,e):this._$AH.handleEvent(e)}}class Ae{constructor(e,t,i){this.element=e,this.type=6,this._$AN=void 0,this._$AM=t,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(e){E(this,e)}}const Ee=W.litHtmlPolyfillSupport;Ee?.(H,B),(W.litHtmlVersions??=[]).push("3.3.1");const Se=(n,e,t)=>{const i=t?.renderBefore??e;let s=i._$litPart$;if(s===void 0){const o=t?.renderBefore??null;i._$litPart$=s=new B(e.insertBefore(k(),o),o,void 0,t??{})}return s._$AI(n),s};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const L=globalThis;class c extends _{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){const e=super.createRenderRoot();return this.renderOptions.renderBefore??=e.firstChild,e}update(e){const t=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(e),this._$Do=Se(t,this.renderRoot,this.renderOptions)}connectedCallback(){super.connectedCallback(),this._$Do?.setConnected(!0)}disconnectedCallback(){super.disconnectedCallback(),this._$Do?.setConnected(!1)}render(){return A}}c._$litElement$=!0,c.finalized=!0,L.litElementHydrateSupport?.({LitElement:c});const Pe=L.litElementPolyfillSupport;Pe?.({LitElement:c});(L.litElementVersions??=[]).push("4.2.1");const g=h`
  h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-poppins);
    color: var(--color-headline-1);
    margin: 0;
    padding: 0;
  }

  p {
    color: var(--color-paragraph-1);
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
`;class ke extends c{static styles=[g,h`
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
        `}}customElements.define("dots-container",ke);class Ce extends c{static properties={href:{type:String},external:{type:Boolean}};static styles=[g,h`
        .button {
            height: inherit;
            border-right: 1px solid var(--border-color-1);
            padding: 0 3em;
            display: flex;
            align-items: center;
            transition: background .2s ease;
            text-transform: uppercase;
            gap: 0.75em;
        }

        .button:hover {
            background: var(--bg-1-hover);
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
        `}}customElements.define("boson-header-button",Ce);class He extends c{static properties={href:{type:String},external:{type:Boolean},active:{type:Boolean}};static styles=[g,h`
        .link {
            color: var(--color-paragraph-1);
            transition-duration: 0.2s;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .link.active,
        .link:hover {
            color: var(--red);
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
        `}}customElements.define("boson-header-link",He);class Be extends c{static properties={};static styles=[g,h`
        details > summary {
            list-style-type: '';
        }

        details > summary::-webkit-details-marker,
        details > summary::marker {
            display: none;
        }

        .dropdown {
            position: relative;
            padding-right: 24px;
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
            border: solid 2px var(--red);
            border-right-color: transparent;
            border-bottom-color: transparent;
            transition: .2s ease;
            border-radius: 1px;

            position: absolute;
            top: 50%;
            right: -14px;
            margin-top: -2.2px;

            transform-origin: 2px 2px;
            transform: rotate(225deg);
        }

        .dropdown-list {
            position: absolute;
            line-height: 42px;
            background: var(--bg-dark);
            border: 1px solid var(--grey-bg);
            padding: 10px 20px;
            display: flex;
            min-width: 200px;
            flex-direction: column;
            flex-wrap: nowrap;
            margin-top: -20px;
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
        `}}customElements.define("boson-header-dropdown",Be);class Te extends c{static properties={isScrolled:{type:Boolean}};static styles=[h`
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
            border-bottom: 1px solid var(--border-color-1);
            transition-duration: 0.2s;
            background: var(--bg-1-opacity);
            backdrop-filter: blur(14px);
            z-index: 10;
        }

        .container.scrolled {
            height: 70px;
            line-height: 70px;
        }

        .dots,
        ::slotted(*) {
            height: 100%;
        }

        .dots:nth-child(1) {
            border-right: 1px solid var(--border-color-1);
        }

        .nav {
            flex: 1;
            padding: 0 3em;
            display: flex;
            gap: 3em;
            border-right: 1px solid var(--border-color-1);
            align-self: stretch;
            align-items: center;
        }
    `];constructor(){super(),this.isScrolled=!1,this.isDocsOpen=!1,this.handleScroll=this.handleScroll.bind(this)}connectedCallback(){super.connectedCallback(),window.addEventListener("scroll",this.handleScroll),this.handleScroll()}disconnectedCallback(){super.disconnectedCallback(),window.removeEventListener("scroll",this.handleScroll)}handleScroll(){const e=window.pageYOffset||document.documentElement.scrollTop;this.isScrolled=e>0}render(){return l`
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
        `}}customElements.define("boson-header",Te);class Oe extends c{static styles=[h`
        .container {
            display: flex;
            flex-direction: column;
        }

        .content {
            border-top: 1px solid var(--border-color-1);
            border-bottom: 1px solid var(--border-color-1);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .top {
            display: flex;
            border-bottom: 1px solid var(--border-color-1);
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
            border-right: 1px solid var(--border-color-1);
        }

        ::slotted(a) {
            padding: 3.5em 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 230px;
            border-right: 1px solid var(--border-color-1);
            transition-duration: 0.2s;
        }

        ::slotted(a:hover) {
            background: var(--bg-1-hover);
        }

        [name="secondary-link"]::slotted(a) {
            color: var(--color-paragraph-1) !important;
        }

        [name="secondary-link"]::slotted(a:hover) {
            background: var(--bg-1-hover) !important;
        }

        .dots-main {
            flex: 1;
            border-right: 1px solid var(--border-color-1);
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
            border-right: 1px solid var(--border-color-1);
            display: flex;
            align-items: center;
            margin-left: 3em;
            font-size: max(1rem, min(.55rem + .55vw, 2rem));
            line-height: 1.75;
            color: var(--color-paragraph-1);
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
        `}}customElements.define("boson-footer",Oe);class ze extends c{static properties={href:{type:String},text:{type:String}};static styles=[g,h`
        .button {
            transition-duration: 0.2s;
            background: var(--grey-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 1em;
            text-transform: uppercase;
        }

        .button:hover {
            background: var(--grey-bg-hover);
        }

        .text {
            margin-left: 1em;
            color: var(--color-headline-1);
        }

        .box {
            height: 35px;
            width: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-headline-1);
        }
    `];constructor(){super(),this.href="/",this.text=""}render(){return l`
            <a href="${this.href}" class="button">
                <span class="text">${this.text}</span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_secondary.svg" alt="arrow_secondary"/>
                </div>
            </a>
        `}}customElements.define("button-secondary",ze);class Me extends c{static properties={href:{type:String},text:{type:String}};static styles=[g,h`
        .button {
            transition-duration: 0.2s;
            background: var(--red-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 1em;
            text-transform: uppercase;
        }

        .button:hover {
            background: var(--red-bg-hover);
        }

        .text {
            margin-left: 1em;
            color: var(--red);
        }

        .box {
            height: 35px;
            width: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--red);
        }
    `];constructor(){super(),this.href="/",this.text=""}render(){return l`
            <a href="${this.href}" class="button">
                <span class="text">${this.text}</span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_primary.svg" alt="arrow_primary"/>
                </div>
            </a>
        `}}customElements.define("button-primary",Me);class Ne extends c{static styles=[g,h`
        .container {
            display: flex;
            flex-direction: column;
            width: var(--content-width);
            margin: 10em auto 0;
            gap: 3em;
        }

        .top {
            display: flex;
            flex-direction: row;
            align-items: center;
            flex: 1;
            gap: 2em;
            justify-content: space-between;
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
            color: var(--red);
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
            border-top: 1px solid var(--grey-bg);
        }

        .bottom:hover {
            padding: 3em 2em;
            background-color: var(--grey-bg);
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
        `}}customElements.define("hero-section",Ne);class Ue extends c{static properties={name:{type:String}};static styles=[g,h`
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
        `}}customElements.define("subtitle-component",Ue);class je extends c{static styles=[g,h`
        .container {
            display: flex;
            flex-direction: column;
            margin-bottom: 2em;
        }

        .top {
            display: flex;
            width: var(--content-width);
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
        `}}customElements.define("nativeness-section",je);class Ie extends c{static styles=[g,h`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            width: var(--content-width);
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
            color: var(--red);
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
            border-bottom: 1px solid var(--border-color-1);
            border-top: 1px solid var(--border-color-1);
        }

        .dots {
            min-width: 120px;
        }

        .content .dots:nth-child(1) {
            border-right: 1px solid var(--border-color-1);
        }

        .inner {
            display: flex;
            flex: 1;
        }

        .solves {
            border-right: 1px solid var(--border-color-1);
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
        `}}customElements.define("solves-section",Ie);class Re extends c{static properties={content:{type:Array},openIndex:{type:Number}};static styles=[g,h`
        .accordion {
            display: flex;
            height: 24rem;
            flex: 1;
        }

        .element {
            border-right: 1px solid var(--border-color-1);
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
            background: var(--bg-1-hover);
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
            color: var(--red);
            transition-duration: 0.2s;
        }

        .elementClosed .elementContent .closedTop .number {
            color: var(--color-paragraph-1);
        }

        .elementClosed:hover .elementContent .closedTop .number {
            color: var(--red);
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
        `}}customElements.define("horizontal-accordion",Re);class We extends c{static styles=[g,h`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            width: var(--content-width);
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
            border-bottom: 1px solid var(--border-color-1);
            border-top: 1px solid var(--border-color-1);
        }

        .dots {
            min-width: 120px;
        }

        .content .dots:nth-child(1) {
            border-right: 1px solid var(--border-color-1);
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
        `}}customElements.define("how-it-works-section",We);class De extends c{static styles=[g,h`
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
            color: var(--red);
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
        `}}customElements.define("right-choice-section",De);class Le extends c{static styles=[g,h`
        .container {
            display: flex;
            justify-content: center;
            position: relative;
            border-top: 1px solid var(--border-color-1);
        }

        .left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-self: stretch;
            position: relative;
            border-right: 1px solid var(--border-color-1);
            border-bottom: 1px solid var(--border-color-1);
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
            color: var(--red);
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
            border-bottom: 1px solid var(--border-color-1);
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
        `}}customElements.define("mobile-development-section",Le);class Ve extends c{static properties={slides:{type:Array},currentIndex:{type:Number},slidesPerView:{type:Number}};static styles=[g,h`
        .container {
            display: flex;
            max-width: 100vw;
            overflow: hidden;
            border-top: 1px solid var(--border-color-1);
            border-bottom: 1px solid var(--border-color-1);
            background: var(--bg-1);
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
            background-color: var(--bg-1-hover);
        }

        .sliderButton:nth-child(1) {
            border-right: 1px solid var(--border-color-1);
        }

        .sliderButton:nth-last-child(1) {
            border-left: 1px solid var(--border-color-1);
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
            border-right: 1px solid var(--border-color-1);
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
            color: var(--red);
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
        `}}customElements.define("slider-component",Ve);class qe extends c{static styles=[g,h`
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
        `}}customElements.define("testimonials-section",qe);class Fe extends c{static styles=[g,h`
        .container {
            padding-bottom: 8em;
            background-size: 900px 900px;
            background: url("/images/hero.svg") no-repeat 115% 0;
        }

        .wrapper {
            width: var(--content-width);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 3em;
            align-items: flex-start;
        }

        .red {
            color: var(--red);
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
        `}}customElements.define("call-to-action-section",Fe);class Ye extends c{static styles=[g,h`
        .page {
            display: flex;
            flex-direction: column;
            gap: 8em;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
        }
    `];render(){return l`
            <main class="page">
                <hero-section></hero-section>
                <nativeness-section></nativeness-section>
                <solves-section></solves-section>
                <div class="wrapper">
                    <how-it-works-section></how-it-works-section>
                    <right-choice-section></right-choice-section>
                </div>
                <mobile-development-section></mobile-development-section>
                <testimonials-section></testimonials-section>
                <call-to-action-section></call-to-action-section>
            </main>
        `}}customElements.define("home-page",Ye);
