/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const I=globalThis,R=I.ShadowRoot&&(I.ShadyCSS===void 0||I.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,L=Symbol(),F=new WeakMap;let ie=class{constructor(e,t,i){if(this._$cssResult$=!0,i!==L)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=e,this.t=t}get styleSheet(){let e=this.o;const t=this.t;if(R&&e===void 0){const i=t!==void 0&&t.length===1;i&&(e=F.get(t)),e===void 0&&((this.o=e=new CSSStyleSheet).replaceSync(this.cssText),i&&F.set(t,e))}return e}toString(){return this.cssText}};const le=o=>new ie(typeof o=="string"?o:o+"",void 0,L),h=(o,...e)=>{const t=o.length===1?o[0]:e.reduce((i,s,n)=>i+(r=>{if(r._$cssResult$===!0)return r.cssText;if(typeof r=="number")return r;throw Error("Value passed to 'css' function must be a 'css' function result: "+r+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(s)+o[n+1],o[0]);return new ie(t,o,L)},de=(o,e)=>{if(R)o.adoptedStyleSheets=e.map(t=>t instanceof CSSStyleSheet?t:t.styleSheet);else for(const t of e){const i=document.createElement("style"),s=I.litNonce;s!==void 0&&i.setAttribute("nonce",s),i.textContent=t.cssText,o.appendChild(i)}},Y=R?o=>o:o=>o instanceof CSSStyleSheet?(e=>{let t="";for(const i of e.cssRules)t+=i.cssText;return le(t)})(o):o;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:ce,defineProperty:pe,getOwnPropertyDescriptor:he,getOwnPropertyNames:me,getOwnPropertySymbols:ue,getPrototypeOf:ge}=Object,M=globalThis,X=M.trustedTypes,fe=X?X.emptyScript:"",ve=M.reactiveElementPolyfillSupport,E=(o,e)=>o,N={toAttribute(o,e){switch(e){case Boolean:o=o?fe:null;break;case Object:case Array:o=o==null?o:JSON.stringify(o)}return o},fromAttribute(o,e){let t=o;switch(e){case Boolean:t=o!==null;break;case Number:t=o===null?null:Number(o);break;case Object:case Array:try{t=JSON.parse(o)}catch{t=null}}return t}},se=(o,e)=>!ce(o,e),J={attribute:!0,type:String,converter:N,reflect:!1,useDefault:!1,hasChanged:se};Symbol.metadata??=Symbol("metadata"),M.litPropertyMetadata??=new WeakMap;let _=class extends HTMLElement{static addInitializer(e){this._$Ei(),(this.l??=[]).push(e)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(e,t=J){if(t.state&&(t.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(e)&&((t=Object.create(t)).wrapped=!0),this.elementProperties.set(e,t),!t.noAccessor){const i=Symbol(),s=this.getPropertyDescriptor(e,i,t);s!==void 0&&pe(this.prototype,e,s)}}static getPropertyDescriptor(e,t,i){const{get:s,set:n}=he(this.prototype,e)??{get(){return this[t]},set(r){this[t]=r}};return{get:s,set(r){const c=s?.call(this);n?.call(this,r),this.requestUpdate(e,c,i)},configurable:!0,enumerable:!0}}static getPropertyOptions(e){return this.elementProperties.get(e)??J}static _$Ei(){if(this.hasOwnProperty(E("elementProperties")))return;const e=ge(this);e.finalize(),e.l!==void 0&&(this.l=[...e.l]),this.elementProperties=new Map(e.elementProperties)}static finalize(){if(this.hasOwnProperty(E("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(E("properties"))){const t=this.properties,i=[...me(t),...ue(t)];for(const s of i)this.createProperty(s,t[s])}const e=this[Symbol.metadata];if(e!==null){const t=litPropertyMetadata.get(e);if(t!==void 0)for(const[i,s]of t)this.elementProperties.set(i,s)}this._$Eh=new Map;for(const[t,i]of this.elementProperties){const s=this._$Eu(t,i);s!==void 0&&this._$Eh.set(s,t)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(e){const t=[];if(Array.isArray(e)){const i=new Set(e.flat(1/0).reverse());for(const s of i)t.unshift(Y(s))}else e!==void 0&&t.push(Y(e));return t}static _$Eu(e,t){const i=t.attribute;return i===!1?void 0:typeof i=="string"?i:typeof e=="string"?e.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),this.constructor.l?.forEach(e=>e(this))}addController(e){(this._$EO??=new Set).add(e),this.renderRoot!==void 0&&this.isConnected&&e.hostConnected?.()}removeController(e){this._$EO?.delete(e)}_$E_(){const e=new Map,t=this.constructor.elementProperties;for(const i of t.keys())this.hasOwnProperty(i)&&(e.set(i,this[i]),delete this[i]);e.size>0&&(this._$Ep=e)}createRenderRoot(){const e=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return de(e,this.constructor.elementStyles),e}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$EO?.forEach(e=>e.hostConnected?.())}enableUpdating(e){}disconnectedCallback(){this._$EO?.forEach(e=>e.hostDisconnected?.())}attributeChangedCallback(e,t,i){this._$AK(e,i)}_$ET(e,t){const i=this.constructor.elementProperties.get(e),s=this.constructor._$Eu(e,i);if(s!==void 0&&i.reflect===!0){const n=(i.converter?.toAttribute!==void 0?i.converter:N).toAttribute(t,i.type);this._$Em=e,n==null?this.removeAttribute(s):this.setAttribute(s,n),this._$Em=null}}_$AK(e,t){const i=this.constructor,s=i._$Eh.get(e);if(s!==void 0&&this._$Em!==s){const n=i.getPropertyOptions(s),r=typeof n.converter=="function"?{fromAttribute:n.converter}:n.converter?.fromAttribute!==void 0?n.converter:N;this._$Em=s;const c=r.fromAttribute(t,n.type);this[s]=c??this._$Ej?.get(s)??c,this._$Em=null}}requestUpdate(e,t,i){if(e!==void 0){const s=this.constructor,n=this[e];if(i??=s.getPropertyOptions(e),!((i.hasChanged??se)(n,t)||i.useDefault&&i.reflect&&n===this._$Ej?.get(e)&&!this.hasAttribute(s._$Eu(e,i))))return;this.C(e,t,i)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(e,t,{useDefault:i,reflect:s,wrapped:n},r){i&&!(this._$Ej??=new Map).has(e)&&(this._$Ej.set(e,r??t??this[e]),n!==!0||r!==void 0)||(this._$AL.has(e)||(this.hasUpdated||i||(t=void 0),this._$AL.set(e,t)),s===!0&&this._$Em!==e&&(this._$Eq??=new Set).add(e))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(t){Promise.reject(t)}const e=this.scheduleUpdate();return e!=null&&await e,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[s,n]of this._$Ep)this[s]=n;this._$Ep=void 0}const i=this.constructor.elementProperties;if(i.size>0)for(const[s,n]of i){const{wrapped:r}=n,c=this[s];r!==!0||this._$AL.has(s)||c===void 0||this.C(s,void 0,n,c)}}let e=!1;const t=this._$AL;try{e=this.shouldUpdate(t),e?(this.willUpdate(t),this._$EO?.forEach(i=>i.hostUpdate?.()),this.update(t)):this._$EM()}catch(i){throw e=!1,this._$EM(),i}e&&this._$AE(t)}willUpdate(e){}_$AE(e){this._$EO?.forEach(t=>t.hostUpdated?.()),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(e)),this.updated(e)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(e){return!0}update(e){this._$Eq&&=this._$Eq.forEach(t=>this._$ET(t,this[t])),this._$EM()}updated(e){}firstUpdated(e){}};_.elementStyles=[],_.shadowRootOptions={mode:"open"},_[E("elementProperties")]=new Map,_[E("finalized")]=new Map,ve?.({ReactiveElement:_}),(M.reactiveElementVersions??=[]).push("2.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const W=globalThis,O=W.trustedTypes,K=O?O.createPolicy("lit-html",{createHTML:o=>o}):void 0,oe="$lit$",b=`lit$${Math.random().toFixed(9).slice(2)}$`,ne="?"+b,xe=`<${ne}>`,w=document,P=()=>w.createComment(""),C=o=>o===null||typeof o!="object"&&typeof o!="function",D=Array.isArray,be=o=>D(o)||typeof o?.[Symbol.iterator]=="function",j=`[ 	
\f\r]`,S=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,G=/-->/g,Z=/>/g,y=RegExp(`>|${j}(?:([^\\s"'>=/]+)(${j}*=${j}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),Q=/'/g,ee=/"/g,re=/^(?:script|style|textarea|title)$/i,ye=o=>(e,...t)=>({_$litType$:o,strings:e,values:t}),l=ye(1),A=Symbol.for("lit-noChange"),g=Symbol.for("lit-nothing"),te=new WeakMap,$=w.createTreeWalker(w,129);function ae(o,e){if(!D(o)||!o.hasOwnProperty("raw"))throw Error("invalid template strings array");return K!==void 0?K.createHTML(e):e}const $e=(o,e)=>{const t=o.length-1,i=[];let s,n=e===2?"<svg>":e===3?"<math>":"",r=S;for(let c=0;c<t;c++){const a=o[c];let m,u,d=-1,v=0;for(;v<a.length&&(r.lastIndex=v,u=r.exec(a),u!==null);)v=r.lastIndex,r===S?u[1]==="!--"?r=G:u[1]!==void 0?r=Z:u[2]!==void 0?(re.test(u[2])&&(s=RegExp("</"+u[2],"g")),r=y):u[3]!==void 0&&(r=y):r===y?u[0]===">"?(r=s??S,d=-1):u[1]===void 0?d=-2:(d=r.lastIndex-u[2].length,m=u[1],r=u[3]===void 0?y:u[3]==='"'?ee:Q):r===ee||r===Q?r=y:r===G||r===Z?r=S:(r=y,s=void 0);const x=r===y&&o[c+1].startsWith("/>")?" ":"";n+=r===S?a+xe:d>=0?(i.push(m),a.slice(0,d)+oe+a.slice(d)+b+x):a+b+(d===-2?c:x)}return[ae(o,n+(o[t]||"<?>")+(e===2?"</svg>":e===3?"</math>":"")),i]};class H{constructor({strings:e,_$litType$:t},i){let s;this.parts=[];let n=0,r=0;const c=e.length-1,a=this.parts,[m,u]=$e(e,t);if(this.el=H.createElement(m,i),$.currentNode=this.el.content,t===2||t===3){const d=this.el.content.firstChild;d.replaceWith(...d.childNodes)}for(;(s=$.nextNode())!==null&&a.length<c;){if(s.nodeType===1){if(s.hasAttributes())for(const d of s.getAttributeNames())if(d.endsWith(oe)){const v=u[r++],x=s.getAttribute(d).split(b),T=/([.?@])?(.*)/.exec(v);a.push({type:1,index:n,name:T[2],strings:x,ctor:T[1]==="."?_e:T[1]==="?"?Ae:T[1]==="@"?ke:U}),s.removeAttribute(d)}else d.startsWith(b)&&(a.push({type:6,index:n}),s.removeAttribute(d));if(re.test(s.tagName)){const d=s.textContent.split(b),v=d.length-1;if(v>0){s.textContent=O?O.emptyScript:"";for(let x=0;x<v;x++)s.append(d[x],P()),$.nextNode(),a.push({type:2,index:++n});s.append(d[v],P())}}}else if(s.nodeType===8)if(s.data===ne)a.push({type:2,index:n});else{let d=-1;for(;(d=s.data.indexOf(b,d+1))!==-1;)a.push({type:7,index:n}),d+=b.length-1}n++}}static createElement(e,t){const i=w.createElement("template");return i.innerHTML=e,i}}function k(o,e,t=o,i){if(e===A)return e;let s=i!==void 0?t._$Co?.[i]:t._$Cl;const n=C(e)?void 0:e._$litDirective$;return s?.constructor!==n&&(s?._$AO?.(!1),n===void 0?s=void 0:(s=new n(o),s._$AT(o,t,i)),i!==void 0?(t._$Co??=[])[i]=s:t._$Cl=s),s!==void 0&&(e=k(o,s._$AS(o,e.values),s,i)),e}class we{constructor(e,t){this._$AV=[],this._$AN=void 0,this._$AD=e,this._$AM=t}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(e){const{el:{content:t},parts:i}=this._$AD,s=(e?.creationScope??w).importNode(t,!0);$.currentNode=s;let n=$.nextNode(),r=0,c=0,a=i[0];for(;a!==void 0;){if(r===a.index){let m;a.type===2?m=new B(n,n.nextSibling,this,e):a.type===1?m=new a.ctor(n,a.name,a.strings,this,e):a.type===6&&(m=new Se(n,this,e)),this._$AV.push(m),a=i[++c]}r!==a?.index&&(n=$.nextNode(),r++)}return $.currentNode=w,s}p(e){let t=0;for(const i of this._$AV)i!==void 0&&(i.strings!==void 0?(i._$AI(e,i,t),t+=i.strings.length-2):i._$AI(e[t])),t++}}class B{get _$AU(){return this._$AM?._$AU??this._$Cv}constructor(e,t,i,s){this.type=2,this._$AH=g,this._$AN=void 0,this._$AA=e,this._$AB=t,this._$AM=i,this.options=s,this._$Cv=s?.isConnected??!0}get parentNode(){let e=this._$AA.parentNode;const t=this._$AM;return t!==void 0&&e?.nodeType===11&&(e=t.parentNode),e}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(e,t=this){e=k(this,e,t),C(e)?e===g||e==null||e===""?(this._$AH!==g&&this._$AR(),this._$AH=g):e!==this._$AH&&e!==A&&this._(e):e._$litType$!==void 0?this.$(e):e.nodeType!==void 0?this.T(e):be(e)?this.k(e):this._(e)}O(e){return this._$AA.parentNode.insertBefore(e,this._$AB)}T(e){this._$AH!==e&&(this._$AR(),this._$AH=this.O(e))}_(e){this._$AH!==g&&C(this._$AH)?this._$AA.nextSibling.data=e:this.T(w.createTextNode(e)),this._$AH=e}$(e){const{values:t,_$litType$:i}=e,s=typeof i=="number"?this._$AC(e):(i.el===void 0&&(i.el=H.createElement(ae(i.h,i.h[0]),this.options)),i);if(this._$AH?._$AD===s)this._$AH.p(t);else{const n=new we(s,this),r=n.u(this.options);n.p(t),this.T(r),this._$AH=n}}_$AC(e){let t=te.get(e.strings);return t===void 0&&te.set(e.strings,t=new H(e)),t}k(e){D(this._$AH)||(this._$AH=[],this._$AR());const t=this._$AH;let i,s=0;for(const n of e)s===t.length?t.push(i=new B(this.O(P()),this.O(P()),this,this.options)):i=t[s],i._$AI(n),s++;s<t.length&&(this._$AR(i&&i._$AB.nextSibling,s),t.length=s)}_$AR(e=this._$AA.nextSibling,t){for(this._$AP?.(!1,!0,t);e!==this._$AB;){const i=e.nextSibling;e.remove(),e=i}}setConnected(e){this._$AM===void 0&&(this._$Cv=e,this._$AP?.(e))}}class U{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(e,t,i,s,n){this.type=1,this._$AH=g,this._$AN=void 0,this.element=e,this.name=t,this._$AM=s,this.options=n,i.length>2||i[0]!==""||i[1]!==""?(this._$AH=Array(i.length-1).fill(new String),this.strings=i):this._$AH=g}_$AI(e,t=this,i,s){const n=this.strings;let r=!1;if(n===void 0)e=k(this,e,t,0),r=!C(e)||e!==this._$AH&&e!==A,r&&(this._$AH=e);else{const c=e;let a,m;for(e=n[0],a=0;a<n.length-1;a++)m=k(this,c[i+a],t,a),m===A&&(m=this._$AH[a]),r||=!C(m)||m!==this._$AH[a],m===g?e=g:e!==g&&(e+=(m??"")+n[a+1]),this._$AH[a]=m}r&&!s&&this.j(e)}j(e){e===g?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,e??"")}}class _e extends U{constructor(){super(...arguments),this.type=3}j(e){this.element[this.name]=e===g?void 0:e}}class Ae extends U{constructor(){super(...arguments),this.type=4}j(e){this.element.toggleAttribute(this.name,!!e&&e!==g)}}class ke extends U{constructor(e,t,i,s,n){super(e,t,i,s,n),this.type=5}_$AI(e,t=this){if((e=k(this,e,t,0)??g)===A)return;const i=this._$AH,s=e===g&&i!==g||e.capture!==i.capture||e.once!==i.once||e.passive!==i.passive,n=e!==g&&(i===g||s);s&&this.element.removeEventListener(this.name,this,i),n&&this.element.addEventListener(this.name,this,e),this._$AH=e}handleEvent(e){typeof this._$AH=="function"?this._$AH.call(this.options?.host??this.element,e):this._$AH.handleEvent(e)}}class Se{constructor(e,t,i){this.element=e,this.type=6,this._$AN=void 0,this._$AM=t,this.options=i}get _$AU(){return this._$AM._$AU}_$AI(e){k(this,e)}}const Ee=W.litHtmlPolyfillSupport;Ee?.(H,B),(W.litHtmlVersions??=[]).push("3.3.1");const Pe=(o,e,t)=>{const i=t?.renderBefore??e;let s=i._$litPart$;if(s===void 0){const n=t?.renderBefore??null;i._$litPart$=s=new B(e.insertBefore(P(),n),n,void 0,t??{})}return s._$AI(o),s};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const q=globalThis;class p extends _{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){const e=super.createRenderRoot();return this.renderOptions.renderBefore??=e.firstChild,e}update(e){const t=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(e),this._$Do=Pe(t,this.renderRoot,this.renderOptions)}connectedCallback(){super.connectedCallback(),this._$Do?.setConnected(!0)}disconnectedCallback(){super.disconnectedCallback(),this._$Do?.setConnected(!1)}render(){return A}}p._$litElement$=!0,p.finalized=!0,q.litElementHydrateSupport?.({LitElement:p});const Ce=q.litElementPolyfillSupport;Ce?.({LitElement:p});(q.litElementVersions??=[]).push("4.2.1");const f=h`
    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-title);
        color: var(--color-text);
        margin: 0;
        padding: 0;
        line-height: 1.1;
    }
    h1 {
        font-size: clamp(8rem, 1vw + 8rem, 10rem);
    }
    h2 {
        font-size: clamp(3rem, 1vw + 3.5rem, 5rem);
        font-weight: 500;
    }
    h3 {
        font-size: max(2rem, min(2rem + 1vw, 5rem));
        font-weight: 500;
    }
    h4 {
        font-size: max(1.5rem, min(2rem + 1vw, 2.25rem));
        font-weight: 500;
    }
    h5 {
        font-weight: 400;
        font-size: 1.8rem;
    }
    h6 {
        font-weight: 500;
    }

    p {
        font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
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
`;class He extends p{static properties={href:{type:String},text:{type:String}};static styles=[f,h`
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
        `}}customElements.define("button-primary",He);class Be extends p{static properties={href:{type:String},text:{type:String}};static styles=[f,h`
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
        `}}customElements.define("button-secondary",Be);class Te extends p{static styles=[f,h`
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
    `];render(){return l`
            <section class="container">
                <div class="wrapper">
                    <div class="text">
                        <h3>
                            If you are a PHP developer, you can already</br>
                            make native cross-platform applications.</br>
                            Boson PHP makes it possible!</br>
                            <span class="red">Get started right now!</span>
                        </h3>
                    </div>
                    <button-primary text="Try Boson For Free" href="/"></button-primary>
                </div>
            </section>
        `}}customElements.define("call-to-action-section",Te);class Ie extends p{static styles=[f,h`
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

        .white {
            color: var(--color-text);
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
            line-height: 1.1;
        }

        .headlines h1 {
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
                            <h1>Go Native. </br><span class="white">Stay PHP</span></h1>
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
        `}}customElements.define("hero-section",Ie);class Oe extends p{static styles=[f,h`
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
                            <h2>Under the Hood of</br>Boson PHP</h2>
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
        `}}customElements.define("how-it-works-section",Oe);class ze extends p{static styles=[f,h`
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
            text-transform: uppercase;
        }

        .text {
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }
    `];get elements(){return[{text:"For many businesses, mobile devices are the main audience segment. Web applications are good. Desktop clients are great. Mobile applications are wonderful.",icon:"rocket",headline:"Reaching new audiences"},{text:"The same PHP code — but now it works on a mobile device. Budget savings and faster launch.",icon:"clients",headline:"New clients without rewriting code"},{headline:"Convenient for B2B and B2C",icon:"case",text:"Internal CRM, chat applications, offline utilities, task managers, task trackers, dashboards — you can carry everything in your pocket."},{headline:"Without pain and extra stacks",icon:"convenient",text:"One stack. One language. One project. PHP from start to launch in the App Store."}]}renderElement(e){return l`
            <div class="element">
                <div class="top">
                    <img class="icon" src="/images/icons/${e.icon}.svg" alt="${e.headline}"/>
                    <h5 class="name">${e.headline}</h5>
                </div>
                <p class="text">${e.text}</p>
            </div>
        `}render(){return l`
            <section class="container">
                <div class="left">
                    <div class="wrapper">
                        <subtitle-component name="Mobile Development"></subtitle-component>
                        <div class="headline">
                            <h2>Expand Your Business Horizons: <span class="red">PHP Mobile Apps</span></h2>
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
        `}}customElements.define("mobile-development-section",ze);class V extends p{static cfg={delay:2e3};static styles=[f,h`
        * {
        }
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
            display: flex;
            justify-content: center;
            align-items: center;
            align-self: stretch;
            flex-direction: column;
            margin-top: 8em;
        }

        .wtf {
            display: flex;
            align-self: stretch;
        }

        .edge {
            flex: 3;
            border: none !important;
        }

        .full {
            flex: 4;
        }

        .half {
            flex: 2;
        }

        .wtf > div {
            height: 100px;
            border: 1px dashed var(--color-border);
            border-bottom: none;
            transition: 0.3s ease-in-out;
        }

        .icon {
            height: 128px;
            width: 128px;
            background: url("/images/icon.svg") center center no-repeat;
            background-size: contain;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .icon::before {
            z-index: -1;
            position: absolute;
            content: "";
            width: 480px;
            height: 320px;
            background: radial-gradient(50% 50% at 50% 50%, #F93904 0%, #000000 100%);
            opacity: 0.3;
            filter: blur(140px);
        }

        .border-top {
            border-left: 1px dashed var(--color-text-brand);
            height: 100px;
        }

        #border-1 {
            border-right: none;
        }

        #border-2 {
            border-right: none;
        }

        #border-3 {
            border-left: none;
        }

        #border-4 {
            border-left: none;
        }

        .systems {
            display: flex;
            align-self: stretch;
        }

        .system {
            transition: 0.3s ease-in-out;
            position: relative;
            height: 50px;
            flex: 8;
            border: 1px solid var(--color-border);
            border-right: none;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1.5em;
            padding: 5em 0;
            background: var(--color-bg);
        }

        .system::before {
            position: absolute;
            transition: 0.3s ease-in-out;
            content: '';
            z-index: 1;
            inset: -1px;
            pointer-events: none;
            border: 1px dashed transparent;
        }

        #system-4 {
            border-right: 1px solid var(--color-border);
        }
        .system-edge {
            flex: 2;
            border-top: 1px solid var(--color-border);
            border-bottom: 1px solid var(--color-border);
            background: var(--color-bg);
        }

        .system-active {
            border-color: transparent;
        }

        .system-active::before {
            border: 1px dashed var(--color-text-brand);
        }

        .border-active {
            border-color: var(--color-text-brand) !important;
        }

        .border-top-active {
            border-top-color: var(--color-text-brand) !important;
        }

        .logo {
            min-height: 38px;
            max-height: 38px;
            width: 38px;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: contain;
        }

        #system-1 > .logo {
            background-image: url('/images/icons/windows.svg');
        }

        #system-2 > .logo {
            background-image: url('/images/icons/linux.svg');
        }

        #system-3 > .logo {
            background-image: url('/images/icons/apple.svg');
        }

        #system-4 > .logo {
            background-image: url('/images/icons/android.svg');
        }

        .name {
            text-transform: uppercase;
            color: var(--color-text-secondary);
            font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
        }
        .technology-edge {
            flex: 3;
        }
        .technologies {
            display: flex;
            align-self: stretch;
            position: relative;
        }

        .technology {
            flex: 16;
            display: flex;
            position: relative;
        }
        .sticky {
            height: 450px;
            flex-direction: column;
            position: sticky;
            border: 1px solid var(--color-border);
            border-right: none;
            border-top: none;
            background: var(--color-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 5em;
            gap: 1.5em;
        }
        .technologies > .technology:nth-child(1) {
            flex-direction: column;
        }
        .technologies > .technology:nth-child(2) {
            flex-direction: column-reverse;
            height: 600px;
        }
        .technologies > .technology:nth-child(3) {
            flex-direction: column-reverse;
            height: 750px;
        }
        .technologies > .technology:nth-child(1) > .sticky {
        }
        .technologies > .technology:nth-child(2) > .sticky {
            bottom: 0;
        }
        .technologies > .technology:nth-child(3) > .sticky {
            bottom: 0;
        }
        .dots-container {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 150px;
            border-left: 1px solid var(--color-border);
            border-bottom: 1px solid var(--color-border);
        }
        .tech-logo {
            height: 64px;
            min-width: 250px;
            max-width: 250px;
            background-position: center center;
            background-size: contain;
            background-repeat: no-repeat;
        }
        .tech-name {
            text-transform: uppercase;
            color: var(--color-text);
            font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
        }
        .tech-description {
            color: var(--color-text-secondary);
            font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
        }
        #technology-1 > .sticky > .tech-logo {
            background-image: url("/images/icons/php.svg");
        }
        #technology-2 > .sticky > .tech-logo {
            background-image: url("/images/icons/laravel.svg");
        }
        #technology-3 > .sticky > .tech-logo {
            background-image: url("/images/icons/symfony.svg");
        }
    `];static properties={activeIndex:{type:Number,state:!0}};constructor(){super(),this.activeIndex=1,this._intervalId=null}connectedCallback(){super.connectedCallback(),this._startAnimation()}disconnectedCallback(){super.disconnectedCallback(),this._stopAnimation()}_startAnimation(){this._intervalId=setInterval(()=>{this.activeIndex=this.activeIndex===4?1:this.activeIndex+1},V.cfg.delay)}_stopAnimation(){this._intervalId&&(clearInterval(this._intervalId),this._intervalId=null)}_getBorderClass(e){const t=[];return this.activeIndex===e&&t.push("border-active"),this.activeIndex===1&&e===2&&t.push("border-top-active"),this.activeIndex===4&&e===3&&t.push("border-top-active"),t.join(" ")}_getSystemClass(e){return this.activeIndex===e?"system system-active":"system"}render(){return l`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="Nativeness"></subtitle-component>
                        <h2 class="title">
                            Familiar PHP. Now for desktop and mobile applications.
                        </h2>
                    </div>
                    <div class="right">
                        <p>"What makes you think PHP is only for the web?"</p>
                        <p>– Boson is changing the rules of the game!</p>
                    </div>
                </div>
                <div class="content">
                    <div class="icon"></div>
                    <div class="border-top"></div>
                    <div class="wtf">
                        <div class="edge"></div>
                        <div id="border-1" class="full ${this._getBorderClass(1)}"></div>
                        <div id="border-2" class="half ${this._getBorderClass(2)}"></div>
                        <div id="border-3" class="half ${this._getBorderClass(3)}"></div>
                        <div id="border-4" class="full ${this._getBorderClass(4)}"></div>
                        <div class="edge"></div>
                    </div>
                    <div class="systems">
                        <div class="system-edge"></div>
                        <div id="system-1" class="${this._getSystemClass(1)}">
                            <div class="logo"></div>
                            <span class="name">Windows App</span>
                        </div>
                        <div id="system-2" class="${this._getSystemClass(2)}">
                            <div class="logo"></div>
                            <span class="name">Linux App</span>
                        </div>
                        <div id="system-3" class="${this._getSystemClass(3)}">
                            <div class="logo"></div>
                            <span class="name">macOS & iOS App</span>
                        </div>
                        <div id="system-4" class="${this._getSystemClass(4)}">
                            <div class="logo"></div>
                            <span class="name">Android App</span>
                        </div>
                        <div class="system-edge"></div>
                    </div>
                    <div class="technologies">
                        <div class="technology" id="technology-1">
                            <div class="sticky">
                                <div class="tech-logo"></div>
                                <span class="tech-name">Do you write in pure PHP?</span>
                                <span class="tech-description">Boson loves it too!</span>
                            </div>
                        </div>
                        <div class="technology" id="technology-2">
                            <div class="dots-container"><dots-container></dots-container></div>
                            <div class="sticky">
                                <div class="tech-logo"></div>
                                <span class="tech-name">Do you work with Laravel?</span>
                                <span class="tech-description">Use familiar Blade, Livewire, Inertia or Eloquent for UI and logic. Your routes and controllers work just like on the web.</span>

                            </div>
                        </div>
                        <div class="technology" id="technology-3">
                            <div class="dots-container"><dots-container></dots-container></div>
                            <div style="top: 150px" class="dots-container"><dots-container></dots-container></div>
                            <div class="sticky">
                                <div class="tech-logo"></div>
                                <span class="tech-name">Do you prefer Symfony or Yii?</span>
                                <span class="tech-description">Just plug in Boson. Your components and services are ready to work in Desktop or mobile application.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        `}}customElements.define("nativeness-section",V);class z extends p{static styles=[f,h`
        .container {
            background-size: 100% auto;
            background: url("/images/right_choice_bg.png") no-repeat top;
            height: 200vh;
            display: flex;
            flex-direction: column;
        }

        .top {
            margin: 18em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .red {
            color: var(--color-text-brand);
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            border-top: 1px solid var(--color-border);
        }
        .content-top {
            border-bottom: 1px solid var(--color-border);
        }
        .sep {
            min-width: 1px;
            align-self: stretch;
            background: var(--color-border);
        }
        .content-top, .content-bottom {
            display: flex;
            align-self: stretch;
            flex: 1;
        }
        .content-left, .content-right {
            display: flex;
            position: relative;
            flex: 1;
            padding: 4em;
            overflow: hidden;
        }
        .content-top > div {
            align-items: flex-end;
        }
        .content-left {
            justify-content: flex-end;
            mask-image: linear-gradient(to left, transparent 0%, black 4em);
        }
        .content-right {
            justify-content: flex-start;
            mask-image: linear-gradient(to right, transparent 0%, black 4em);
        }

        .inner {
            width: 55%;
            transition: transform 0.25s ease;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1em;
        }
    `];static animationConfig={triggerOffset:-.8,animationDistance:115,speed:4.5};constructor(){super(),this.handleScroll=this.handleScroll.bind(this),this.isIntersecting=!1}firstUpdated(){this.observer=new IntersectionObserver(e=>{e.forEach(t=>{this.isIntersecting=t.isIntersecting,this.isIntersecting?(window.addEventListener("scroll",this.handleScroll,{passive:!0}),this.handleScroll()):window.removeEventListener("scroll",this.handleScroll)})},{rootMargin:"50px 0px 50px 0px",threshold:.1}),this.observer.observe(this)}disconnectedCallback(){super.disconnectedCallback(),this.observer&&this.observer.disconnect(),window.removeEventListener("scroll",this.handleScroll)}handleScroll(){if(!this.isIntersecting)return;const e=this.getBoundingClientRect(),t=window.innerHeight,i=z.animationConfig,s=t*i.triggerOffset,n=e.top,r=e.height;let c=Math.max(0,Math.min(1,(s-n)/(r*.5)))*i.speed;this.animateElements(c)}animateElements(e){const i=z.animationConfig.animationDistance,s=this.shadowRoot.querySelector(".content-top .content-left .inner"),n=this.shadowRoot.querySelector(".content-top .content-right .inner"),r=this.shadowRoot.querySelector(".content-bottom .content-left .inner"),c=this.shadowRoot.querySelector(".content-bottom .content-right .inner");if(!s||!n||!r||!c)return;const a=e*i;s.style.transform=`translateX(${a}%)`;const m=Math.min(0,-i+e*i);n.style.transform=`translateX(${m}%)`;const u=-(e*i);c.style.transform=`translateX(${u}%)`;const d=Math.max(0,i-e*i);r.style.transform=`translateX(${d}%)`}render(){return l`
            <section class="container">
                <div class="top">
                    <h1>Why is Boson PHP</br> <span class="red">the right choice</span> </br>for you?</h1>
                </div>
                <div class="content">
                    <div class="content-top">
                        <div class="content-left">
                            <div class="inner">
                                <h3>Your PHP — On All Devices</h3>
                            </div>
                        </div>
                        <div class="sep"></div>
                        <div class="content-right">
                            <div class="inner">
                                <h3>Your PHP — Is meow</h3>
                            </div>
                        </div>
                    </div>
                    <div class="content-bottom">
                        <div class="content-left">
                            <div class="inner">
                                <p>No need PHP, and that's all you need. Write code oncecOS, Linux, Android, and iOd your app is available everywhere.</p>
                                <button-secondary href="/" text="Read More"></button-secondary>
                            </div>
                        </div>
                        <div class="sep"></div>
                        <div class="content-right">
                            <div class="inner">
                                <p>No need to learn other languages! You already know PHP, and that's all you need. Write code once for the Web and create native apps on Windows, macOS, Linux, Android, and iOS. The same code, and your app is available everywhere.</p>
                                <button-primary href="/" text="Read More"></button-primary>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        `}}customElements.define("right-choice-section",z);class Me extends p{static styles=[f,h`
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

        .solves h5 {
            text-transform: uppercase;
        }
    `];render(){return l`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="Solves"></subtitle-component>
                        <div class="text">
                            <h2>What <span class="red">you can</span> do with Boson?</h2>
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
                            <h5>For developers</h5>
                            <p>Pride in your favorite language, which is not dying! A real desire to create something
                                useful and interesting. Boson will allow you to create applications from scratch, as a
                                framework.</p>
                        </div>
                        <div class="solves">
                            <img src="/images/icons/lock.svg" alt="lock"/>
                            <h5>For business</h5>
                            <p>Desktop application – getting different variants of working applications. Mobile
                                application – expand profits by getting a new segment of the mobile application
                                market.</p>
                        </div>
                        <div class="solves">
                            <img src="/images/icons/web.svg" alt="web"/>
                            <h5>For web studios</h5>
                            <p>No need to expand your staff to make applications for different platforms, work with
                                Bosob and increase your income.</p>
                        </div>
                    </div>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                </div>
            </section>
        `}}customElements.define("solves-section",Me);class Ue extends p{static styles=[f,h`
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
                        <h2>Developers that </br>believe in us</h2>
                    </div>
                </div>
                <div class="content">
                    <slider-component .slides=${this.slides}></slider-component>
                </div>
            </section>
        `}}customElements.define("testimonials-section",Ue);class je extends p{static properties={href:{type:String},external:{type:Boolean}};static styles=[f,h`
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
        `}}customElements.define("boson-header-button",je);class Ne extends p{static properties={};static styles=[f,h`
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
            border: solid 2px var(--color-text-brand);
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
            background: var(--color-bg-layer);
            border: 1px solid var(--color-border);
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
        `}}customElements.define("boson-header-dropdown",Ne);class Re extends p{static properties={href:{type:String},external:{type:Boolean},active:{type:Boolean}};static styles=[f,h`
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
        `}}customElements.define("boson-header-link",Re);class Le extends p{static styles=[f,h`
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
        `}}customElements.define("dots-container",Le);class We extends p{static styles=[h`
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
        `}}customElements.define("boson-footer",We);class De extends p{static properties={isScrolled:{type:Boolean}};static styles=[h`
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
    `];constructor(){super(),this.isScrolled=!1,this.handleScroll=this.handleScroll.bind(this)}connectedCallback(){super.connectedCallback(),window.addEventListener("scroll",this.handleScroll),this.handleScroll()}disconnectedCallback(){super.disconnectedCallback(),window.removeEventListener("scroll",this.handleScroll)}handleScroll(){const e=window.pageYOffset||document.documentElement.scrollTop;this.isScrolled=e>0}render(){return l`
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
        `}}customElements.define("boson-header",De);class qe extends p{static properties={content:{type:Array},openIndex:{type:Number}};static styles=[f,h`
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
                            <h4 class="headline">${e.headline}</h4>
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
        `}}customElements.define("horizontal-accordion",qe);class Ve extends p{static properties={slides:{type:Array},currentIndex:{type:Number},slidesPerView:{type:Number}};static styles=[f,h`
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
            font-size: 1.2rem;
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
                            <span class="name">${e.name}</span>
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
        `}}customElements.define("slider-component",Ve);class Fe extends p{static properties={name:{type:String}};static styles=[f,h`
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
        `}}customElements.define("subtitle-component",Fe);class Ye extends p{static styles=[h`
        .landing-layout {
            display: flex;
            flex-direction: column;
            gap: 8em;
        }
    `];render(){return l`
            <main class="landing-layout">
                <slot></slot>
            </main>
        `}}customElements.define("boson-landing-layout",Ye);
