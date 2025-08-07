/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const L=globalThis,W=L.ShadowRoot&&(L.ShadyCSS===void 0||L.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,F=Symbol(),K=new WeakMap;let le=class{constructor(e,t,s){if(this._$cssResult$=!0,s!==F)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=e,this.t=t}get styleSheet(){let e=this.o;const t=this.t;if(W&&e===void 0){const s=t!==void 0&&t.length===1;s&&(e=K.get(t)),e===void 0&&((this.o=e=new CSSStyleSheet).replaceSync(this.cssText),s&&K.set(t,e))}return e}toString(){return this.cssText}};const ce=n=>new le(typeof n=="string"?n:n+"",void 0,F),y=(n,...e)=>{const t=n.length===1?n[0]:e.reduce((s,o,i)=>s+(r=>{if(r._$cssResult$===!0)return r.cssText;if(typeof r=="number")return r;throw Error("Value passed to 'css' function must be a 'css' function result: "+r+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(o)+n[i+1],n[0]);return new le(t,n,F)},ge=(n,e)=>{if(W)n.adoptedStyleSheets=e.map(t=>t instanceof CSSStyleSheet?t:t.styleSheet);else for(const t of e){const s=document.createElement("style"),o=L.litNonce;o!==void 0&&s.setAttribute("nonce",o),s.textContent=t.cssText,n.appendChild(s)}},Q=W?n=>n:n=>n instanceof CSSStyleSheet?(e=>{let t="";for(const s of e.cssRules)t+=s.cssText;return ce(t)})(n):n;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:ve,defineProperty:fe,getOwnPropertyDescriptor:ye,getOwnPropertyNames:be,getOwnPropertySymbols:xe,getPrototypeOf:$e}=Object,U=globalThis,ee=U.trustedTypes,we=ee?ee.emptyScript:"",_e=U.reactiveElementPolyfillSupport,B=(n,e)=>n,X={toAttribute(n,e){switch(e){case Boolean:n=n?we:null;break;case Object:case Array:n=n==null?n:JSON.stringify(n)}return n},fromAttribute(n,e){let t=n;switch(e){case Boolean:t=n!==null;break;case Number:t=n===null?null:Number(n);break;case Object:case Array:try{t=JSON.parse(n)}catch{t=null}}return t}},de=(n,e)=>!ve(n,e),te={attribute:!0,type:String,converter:X,reflect:!1,useDefault:!1,hasChanged:de};Symbol.metadata??=Symbol("metadata"),U.litPropertyMetadata??=new WeakMap;let S=class extends HTMLElement{static addInitializer(e){this._$Ei(),(this.l??=[]).push(e)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(e,t=te){if(t.state&&(t.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(e)&&((t=Object.create(t)).wrapped=!0),this.elementProperties.set(e,t),!t.noAccessor){const s=Symbol(),o=this.getPropertyDescriptor(e,s,t);o!==void 0&&fe(this.prototype,e,o)}}static getPropertyDescriptor(e,t,s){const{get:o,set:i}=ye(this.prototype,e)??{get(){return this[t]},set(r){this[t]=r}};return{get:o,set(r){const l=o?.call(this);i?.call(this,r),this.requestUpdate(e,l,s)},configurable:!0,enumerable:!0}}static getPropertyOptions(e){return this.elementProperties.get(e)??te}static _$Ei(){if(this.hasOwnProperty(B("elementProperties")))return;const e=$e(this);e.finalize(),e.l!==void 0&&(this.l=[...e.l]),this.elementProperties=new Map(e.elementProperties)}static finalize(){if(this.hasOwnProperty(B("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(B("properties"))){const t=this.properties,s=[...be(t),...xe(t)];for(const o of s)this.createProperty(o,t[o])}const e=this[Symbol.metadata];if(e!==null){const t=litPropertyMetadata.get(e);if(t!==void 0)for(const[s,o]of t)this.elementProperties.set(s,o)}this._$Eh=new Map;for(const[t,s]of this.elementProperties){const o=this._$Eu(t,s);o!==void 0&&this._$Eh.set(o,t)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(e){const t=[];if(Array.isArray(e)){const s=new Set(e.flat(1/0).reverse());for(const o of s)t.unshift(Q(o))}else e!==void 0&&t.push(Q(e));return t}static _$Eu(e,t){const s=t.attribute;return s===!1?void 0:typeof s=="string"?s:typeof e=="string"?e.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),this.constructor.l?.forEach(e=>e(this))}addController(e){(this._$EO??=new Set).add(e),this.renderRoot!==void 0&&this.isConnected&&e.hostConnected?.()}removeController(e){this._$EO?.delete(e)}_$E_(){const e=new Map,t=this.constructor.elementProperties;for(const s of t.keys())this.hasOwnProperty(s)&&(e.set(s,this[s]),delete this[s]);e.size>0&&(this._$Ep=e)}createRenderRoot(){const e=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return ge(e,this.constructor.elementStyles),e}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$EO?.forEach(e=>e.hostConnected?.())}enableUpdating(e){}disconnectedCallback(){this._$EO?.forEach(e=>e.hostDisconnected?.())}attributeChangedCallback(e,t,s){this._$AK(e,s)}_$ET(e,t){const s=this.constructor.elementProperties.get(e),o=this.constructor._$Eu(e,s);if(o!==void 0&&s.reflect===!0){const i=(s.converter?.toAttribute!==void 0?s.converter:X).toAttribute(t,s.type);this._$Em=e,i==null?this.removeAttribute(o):this.setAttribute(o,i),this._$Em=null}}_$AK(e,t){const s=this.constructor,o=s._$Eh.get(e);if(o!==void 0&&this._$Em!==o){const i=s.getPropertyOptions(o),r=typeof i.converter=="function"?{fromAttribute:i.converter}:i.converter?.fromAttribute!==void 0?i.converter:X;this._$Em=o;const l=r.fromAttribute(t,i.type);this[o]=l??this._$Ej?.get(o)??l,this._$Em=null}}requestUpdate(e,t,s){if(e!==void 0){const o=this.constructor,i=this[e];if(s??=o.getPropertyOptions(e),!((s.hasChanged??de)(i,t)||s.useDefault&&s.reflect&&i===this._$Ej?.get(e)&&!this.hasAttribute(o._$Eu(e,s))))return;this.C(e,t,s)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(e,t,{useDefault:s,reflect:o,wrapped:i},r){s&&!(this._$Ej??=new Map).has(e)&&(this._$Ej.set(e,r??t??this[e]),i!==!0||r!==void 0)||(this._$AL.has(e)||(this.hasUpdated||s||(t=void 0),this._$AL.set(e,t)),o===!0&&this._$Em!==e&&(this._$Eq??=new Set).add(e))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(t){Promise.reject(t)}const e=this.scheduleUpdate();return e!=null&&await e,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[o,i]of this._$Ep)this[o]=i;this._$Ep=void 0}const s=this.constructor.elementProperties;if(s.size>0)for(const[o,i]of s){const{wrapped:r}=i,l=this[o];r!==!0||this._$AL.has(o)||l===void 0||this.C(o,void 0,i,l)}}let e=!1;const t=this._$AL;try{e=this.shouldUpdate(t),e?(this.willUpdate(t),this._$EO?.forEach(s=>s.hostUpdate?.()),this.update(t)):this._$EM()}catch(s){throw e=!1,this._$EM(),s}e&&this._$AE(t)}willUpdate(e){}_$AE(e){this._$EO?.forEach(t=>t.hostUpdated?.()),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(e)),this.updated(e)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(e){return!0}update(e){this._$Eq&&=this._$Eq.forEach(t=>this._$ET(t,this[t])),this._$EM()}updated(e){}firstUpdated(e){}};S.elementStyles=[],S.shadowRootOptions={mode:"open"},S[B("elementProperties")]=new Map,S[B("finalized")]=new Map,_e?.({ReactiveElement:S}),(U.reactiveElementVersions??=[]).push("2.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const V=globalThis,O=V.trustedTypes,se=O?O.createPolicy("lit-html",{createHTML:n=>n}):void 0,he="$lit$",_=`lit$${Math.random().toFixed(9).slice(2)}$`,pe="?"+_,Ae=`<${pe}>`,E=document,I=()=>E.createComment(""),q=n=>n===null||typeof n!="object"&&typeof n!="function",Z=Array.isArray,ke=n=>Z(n)||typeof n?.[Symbol.iterator]=="function",Y=`[ 	
\f\r]`,z=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,oe=/-->/g,ie=/>/g,A=RegExp(`>|${Y}(?:([^\\s"'>=/]+)(${Y}*=${Y}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),ne=/'/g,re=/"/g,me=/^(?:script|style|textarea|title)$/i,Ee=n=>(e,...t)=>({_$litType$:n,strings:e,values:t}),p=Ee(1),C=Symbol.for("lit-noChange"),x=Symbol.for("lit-nothing"),ae=new WeakMap,k=E.createTreeWalker(E,129);function ue(n,e){if(!Z(n)||!n.hasOwnProperty("raw"))throw Error("invalid template strings array");return se!==void 0?se.createHTML(e):e}const Se=(n,e)=>{const t=n.length-1,s=[];let o,i=e===2?"<svg>":e===3?"<math>":"",r=z;for(let l=0;l<t;l++){const a=n[l];let d,m,c=-1,v=0;for(;v<a.length&&(r.lastIndex=v,m=r.exec(a),m!==null);)v=r.lastIndex,r===z?m[1]==="!--"?r=oe:m[1]!==void 0?r=ie:m[2]!==void 0?(me.test(m[2])&&(o=RegExp("</"+m[2],"g")),r=A):m[3]!==void 0&&(r=A):r===A?m[0]===">"?(r=o??z,c=-1):m[1]===void 0?c=-2:(c=r.lastIndex-m[2].length,d=m[1],r=m[3]===void 0?A:m[3]==='"'?re:ne):r===re||r===ne?r=A:r===oe||r===ie?r=z:(r=A,o=void 0);const h=r===A&&n[l+1].startsWith("/>")?" ":"";i+=r===z?a+Ae:c>=0?(s.push(d),a.slice(0,c)+he+a.slice(c)+_+h):a+_+(c===-2?l:h)}return[ue(n,i+(n[t]||"<?>")+(e===2?"</svg>":e===3?"</math>":"")),s]};class H{constructor({strings:e,_$litType$:t},s){let o;this.parts=[];let i=0,r=0;const l=e.length-1,a=this.parts,[d,m]=Se(e,t);if(this.el=H.createElement(d,s),k.currentNode=this.el.content,t===2||t===3){const c=this.el.content.firstChild;c.replaceWith(...c.childNodes)}for(;(o=k.nextNode())!==null&&a.length<l;){if(o.nodeType===1){if(o.hasAttributes())for(const c of o.getAttributeNames())if(c.endsWith(he)){const v=m[r++],h=o.getAttribute(c).split(_),f=/([.?@])?(.*)/.exec(v);a.push({type:1,index:i,name:f[2],strings:h,ctor:f[1]==="."?Pe:f[1]==="?"?Me:f[1]==="@"?Re:N}),o.removeAttribute(c)}else c.startsWith(_)&&(a.push({type:6,index:i}),o.removeAttribute(c));if(me.test(o.tagName)){const c=o.textContent.split(_),v=c.length-1;if(v>0){o.textContent=O?O.emptyScript:"";for(let h=0;h<v;h++)o.append(c[h],I()),k.nextNode(),a.push({type:2,index:++i});o.append(c[v],I())}}}else if(o.nodeType===8)if(o.data===pe)a.push({type:2,index:i});else{let c=-1;for(;(c=o.data.indexOf(_,c+1))!==-1;)a.push({type:7,index:i}),c+=_.length-1}i++}}static createElement(e,t){const s=E.createElement("template");return s.innerHTML=e,s}}function P(n,e,t=n,s){if(e===C)return e;let o=s!==void 0?t._$Co?.[s]:t._$Cl;const i=q(e)?void 0:e._$litDirective$;return o?.constructor!==i&&(o?._$AO?.(!1),i===void 0?o=void 0:(o=new i(n),o._$AT(n,t,s)),s!==void 0?(t._$Co??=[])[s]=o:t._$Cl=o),o!==void 0&&(e=P(n,o._$AS(n,e.values),o,s)),e}class Ce{constructor(e,t){this._$AV=[],this._$AN=void 0,this._$AD=e,this._$AM=t}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(e){const{el:{content:t},parts:s}=this._$AD,o=(e?.creationScope??E).importNode(t,!0);k.currentNode=o;let i=k.nextNode(),r=0,l=0,a=s[0];for(;a!==void 0;){if(r===a.index){let d;a.type===2?d=new D(i,i.nextSibling,this,e):a.type===1?d=new a.ctor(i,a.name,a.strings,this,e):a.type===6&&(d=new Te(i,this,e)),this._$AV.push(d),a=s[++l]}r!==a?.index&&(i=k.nextNode(),r++)}return k.currentNode=E,o}p(e){let t=0;for(const s of this._$AV)s!==void 0&&(s.strings!==void 0?(s._$AI(e,s,t),t+=s.strings.length-2):s._$AI(e[t])),t++}}class D{get _$AU(){return this._$AM?._$AU??this._$Cv}constructor(e,t,s,o){this.type=2,this._$AH=x,this._$AN=void 0,this._$AA=e,this._$AB=t,this._$AM=s,this.options=o,this._$Cv=o?.isConnected??!0}get parentNode(){let e=this._$AA.parentNode;const t=this._$AM;return t!==void 0&&e?.nodeType===11&&(e=t.parentNode),e}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(e,t=this){e=P(this,e,t),q(e)?e===x||e==null||e===""?(this._$AH!==x&&this._$AR(),this._$AH=x):e!==this._$AH&&e!==C&&this._(e):e._$litType$!==void 0?this.$(e):e.nodeType!==void 0?this.T(e):ke(e)?this.k(e):this._(e)}O(e){return this._$AA.parentNode.insertBefore(e,this._$AB)}T(e){this._$AH!==e&&(this._$AR(),this._$AH=this.O(e))}_(e){this._$AH!==x&&q(this._$AH)?this._$AA.nextSibling.data=e:this.T(E.createTextNode(e)),this._$AH=e}$(e){const{values:t,_$litType$:s}=e,o=typeof s=="number"?this._$AC(e):(s.el===void 0&&(s.el=H.createElement(ue(s.h,s.h[0]),this.options)),s);if(this._$AH?._$AD===o)this._$AH.p(t);else{const i=new Ce(o,this),r=i.u(this.options);i.p(t),this.T(r),this._$AH=i}}_$AC(e){let t=ae.get(e.strings);return t===void 0&&ae.set(e.strings,t=new H(e)),t}k(e){Z(this._$AH)||(this._$AH=[],this._$AR());const t=this._$AH;let s,o=0;for(const i of e)o===t.length?t.push(s=new D(this.O(I()),this.O(I()),this,this.options)):s=t[o],s._$AI(i),o++;o<t.length&&(this._$AR(s&&s._$AB.nextSibling,o),t.length=o)}_$AR(e=this._$AA.nextSibling,t){for(this._$AP?.(!1,!0,t);e!==this._$AB;){const s=e.nextSibling;e.remove(),e=s}}setConnected(e){this._$AM===void 0&&(this._$Cv=e,this._$AP?.(e))}}class N{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(e,t,s,o,i){this.type=1,this._$AH=x,this._$AN=void 0,this.element=e,this.name=t,this._$AM=o,this.options=i,s.length>2||s[0]!==""||s[1]!==""?(this._$AH=Array(s.length-1).fill(new String),this.strings=s):this._$AH=x}_$AI(e,t=this,s,o){const i=this.strings;let r=!1;if(i===void 0)e=P(this,e,t,0),r=!q(e)||e!==this._$AH&&e!==C,r&&(this._$AH=e);else{const l=e;let a,d;for(e=i[0],a=0;a<i.length-1;a++)d=P(this,l[s+a],t,a),d===C&&(d=this._$AH[a]),r||=!q(d)||d!==this._$AH[a],d===x?e=x:e!==x&&(e+=(d??"")+i[a+1]),this._$AH[a]=d}r&&!o&&this.j(e)}j(e){e===x?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,e??"")}}class Pe extends N{constructor(){super(...arguments),this.type=3}j(e){this.element[this.name]=e===x?void 0:e}}class Me extends N{constructor(){super(...arguments),this.type=4}j(e){this.element.toggleAttribute(this.name,!!e&&e!==x)}}class Re extends N{constructor(e,t,s,o,i){super(e,t,s,o,i),this.type=5}_$AI(e,t=this){if((e=P(this,e,t,0)??x)===C)return;const s=this._$AH,o=e===x&&s!==x||e.capture!==s.capture||e.once!==s.once||e.passive!==s.passive,i=e!==x&&(s===x||o);o&&this.element.removeEventListener(this.name,this,s),i&&this.element.addEventListener(this.name,this,e),this._$AH=e}handleEvent(e){typeof this._$AH=="function"?this._$AH.call(this.options?.host??this.element,e):this._$AH.handleEvent(e)}}class Te{constructor(e,t,s){this.element=e,this.type=6,this._$AN=void 0,this._$AM=t,this.options=s}get _$AU(){return this._$AM._$AU}_$AI(e){P(this,e)}}const ze=V.litHtmlPolyfillSupport;ze?.(H,D),(V.litHtmlVersions??=[]).push("3.3.1");const Be=(n,e,t)=>{const s=t?.renderBefore??e;let o=s._$litPart$;if(o===void 0){const i=t?.renderBefore??null;s._$litPart$=o=new D(e.insertBefore(I(),i),i,void 0,t??{})}return o._$AI(n),o};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const J=globalThis;class g extends S{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){const e=super.createRenderRoot();return this.renderOptions.renderBefore??=e.firstChild,e}update(e){const t=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(e),this._$Do=Be(t,this.renderRoot,this.renderOptions)}connectedCallback(){super.connectedCallback(),this._$Do?.setConnected(!0)}disconnectedCallback(){super.disconnectedCallback(),this._$Do?.setConnected(!1)}render(){return C}}g._$litElement$=!0,g.finalized=!0,J.litElementHydrateSupport?.({LitElement:g});const Ie=J.litElementPolyfillSupport;Ie?.({LitElement:g});(J.litElementVersions??=[]).push("4.2.1");const qe='h1,h2,h3,h4,h5,h6{font-family:var(--font-title),sans-serif;color:var(--color-text);margin:0;padding:0}h1{font-size:var(--font-size-h1);line-height:var(--font-line-height-h1);font-weight:600}h2{font-size:var(--font-size-h2);line-height:var(--font-line-height-h2);font-weight:500}h3{font-size:var(--font-size-h3);line-height:var(--font-line-height-h3);font-weight:400}h4{font-size:var(--font-size-h4);line-height:var(--font-line-height-h4);font-weight:400}h5{font-size:var(--font-size-h5);line-height:var(--font-line-height-h5);text-transform:uppercase;font-weight:400}h6{font-size:var(--font-size-h6);line-height:var(--font-line-height-h6);text-transform:uppercase;font-weight:400}pre,code{font-family:var(--font-mono),monospace}a:visited,a{color:inherit;text-decoration:none;position:relative}a:after{content:"";height:.1rem;width:100%;display:inline-block;background:#da2f2e;position:absolute;left:0;bottom:0;transform:scaleX(0);transition:transform .2s ease;transform-origin:100% 0}a:hover{color:var(--color-text-brand);text-decoration:none}a:hover:after{transform:scaleX(1);transform-origin:0 0;transition:transform .3s ease}.emphasis{color:var(--color-text-brand)}ul>li{margin:1.3em 0}p{margin:1em 0}*{box-sizing:border-box}@media (orientation: portrait){h1{font-size:5rem}h2{font-size:clamp(3rem,1vw + 3.5rem,5rem)}h3{font-size:max(2rem,min(2rem + 1vw,5rem))}h4{font-size:max(1.5rem,min(2rem + 1vw,2.25rem))}p{font-size:1.25rem}}',$=ce(qe);class He extends g{static properties={type:{type:String}};static styles=[$,y`
        .container {
            display: flex;
            flex-direction: row;
            margin: var(--landing-layout-gap) auto 0 auto;
            gap: 3em;
            max-width: min(var(--width-max), 90vw);
        }

        .segment-title {
            display: flex;
            flex-direction: column;
            flex: 3;
            align-items: flex-start;
            gap: 2em;
        }

        .segment-content {
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: var(--color-text-secondary);
        }

        .segment-title .segment-subtitle {
            display: flex;
            gap: 1em;
            justify-content: center;
            align-items: center;
        }

        .segment-title .segment-subtitle .segment-name {
            font-size: var(--font-size-secondary);
        }

        .segment-title .segment-subtitle svg {
            user-select: none;
        }

        .segment-title .segment-subtitle path {
            fill: var(--color-text-brand);
        }

        ::slotted(.anchor) {
            position: relative;
            top: -250px;
        }

        ::slotted(boson-button) {
            margin-top: 1em;
        }

        ::slotted(ul) {
            list-style-image: url(/images/icons/check.svg);
        }

        /** VERTICAL TYPE */

        .container.container-vertical {
            flex-direction: column;
        }

        /** CENTER TYPE */

        .container.container-center {
            align-items: center;
            flex-direction: column;
        }

        .container.container-center ::slotted(span),
        .container.container-center .title,
        .container.container-center .segment-title {
            text-align: center;
            align-items: center;
        }
    `];constructor(){super(),this.type="horizontal"}render(){return p`
            <section class="container container-${this.type}">
                <hgroup class="segment-title">
                    <div class="segment-subtitle">
                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.20167 0L1.03888 14H0L3.15125 0H4.20167Z" />
                            <path d="M12 0L8.8372 14H7.79833L10.9496 0H12Z" />
                        </svg>

                        <h6 class="segment-name">
                            <slot name="section"></slot>
                        </h6>
                    </div>

                    <h2 class="title">
                        <slot name="title"></slot>
                    </h2>
                </hgroup>

                <aside class="segment-content">
                    <slot></slot>
                </aside>
            </section>
        `}}customElements.define("segment-section",He);class De extends g{static styles=[$,y`
        .container {
            padding-bottom: 8em;
            background-size: 900px 900px;
            background: url("/images/hero.svg") no-repeat 115% 0;
        }

        .wrapper {
            width: var(--width-content);
            max-width: var(--width-max);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 3em;
            align-items: flex-start;
        }

        ::slotted(.red) {
            color: var(--color-text-brand) !important;
        }
    `];render(){return p`
            <section class="container">
                <div class="wrapper">
                    <div class="text">
                        <slot></slot>
                    </div>

                    <slot name="footer"></slot>
                </div>
            </section>
        `}}customElements.define("call-to-action-section",De);class Le extends g{static styles=[$,y`
        .container {
            display: flex;
            flex-direction: column;
            margin: 0 auto;
            min-height: calc(100vh - 100px);
        }

        .top {
            display: flex;
            flex-direction: row;
            align-items: center;
            flex: 1;
            gap: 2em;
            justify-content: space-between;
            margin: 0 auto;
            padding: 3em 0;
            max-width: var(--width-max);
            width: var(--width-content);
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

        .headlines ::slotted(h1),
        .headlines ::slotted(h2) {
            font-size: var(--font-size-h1) !important;
        }

        .headlines ::slotted(h1) {
            color: var(--color-text-brand) !important;
        }

        .description {
            width: 80%;
            color: var(--color-text-secondary);
        }

        .buttons {
            display: flex;
            flex-direction: row;
            gap: 3em;
        }

        .bottom {
            display: flex;
            align-items: center;
            border-top: 1px solid var(--color-border);
            text-transform: uppercase;
            width: 100%;
        }

        .bottom .discover {
            width: 100%;
            transition-duration: 0.2s;
            font-family: var(--font-title), sans-serif;
            font-size: var(--font-size-secondary);
            letter-spacing: .1em;
            text-decoration: none;
        }

        .bottom .discover-container {
            transition-duration: 0.2s;
            max-width: var(--width-max);
            width: var(--width-content);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 3em 0;
        }

        .bottom .discover-icon {
            user-select: none;
        }

        .bottom .discover:hover {
            background-color: var(--color-bg-hover);
        }

        .bottom .discover:hover .discover-container {
            padding: 3em 2em;
        }

        .logo-container {
            display: flex;
            aspect-ratio: 1/1;
        }

        @media (orientation: portrait) {
            .top {
                flex-direction: column;
                padding: 5em 0;
            }

            .text {
                margin: 0 1em;
            }

            .buttons {
                flex-direction: column;
                align-items: flex-start;
                gap: 1em;
            }

            .img {
                max-width: 90vw;
            }

            .bottom {
                padding: 3em 1em;
            }
        }
    `];render(){return p`
            <section class="container">
                <div class="top">
                    <div class="text">
                        <div class="headlines">
                            <hgroup>
                                <slot name="title"></slot>
                            </hgroup>
                        </div>

                        <p class="description">
                            <slot name="description"></slot>
                        </p>

                        <div class="buttons">
                            <slot name="buttons"></slot>
                        </div>
                    </div>

                    <div class="img">
                        <div class="logo-container">
                            <boson-logo></boson-logo>
                        </div>
                    </div>
                </div>

                <aside class="bottom">
                    <a href="#nativeness" class="discover">
                        <span class="discover-container">
                            <span class="discover-text">
                                <slot name="discovery"></slot>
                            </span>

                            <img class="discover-icon"
                                 src="/images/icons/arrow_down.svg" alt="down arrow"/>
                        </span>
                    </a>
                </aside>
            </section>
        `}}customElements.define("hero-section",Le);class Oe extends g{static styles=[$,y`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
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
            flex-direction: column;
            flex: 1;
        }
    `];get content(){return[{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a falications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson antly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create and resource consumption, significantly outperforming Electron in terms of performance."}]}render(){return p`
            <section class="container">
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
        `}}customElements.define("how-it-works-section",Oe);class je extends g{static styles=[$,y`
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
            color: var(--color-text-secondary);
        }
    `];get elements(){return[{text:"For many businesses, mobile devices are the main audience segment. Web applications are good. Desktop clients are great. Mobile applications are wonderful.",icon:"rocket",headline:"Reaching new audiences"},{text:"The same PHP code — but now it works on a mobile device. Budget savings and faster launch.",icon:"clients",headline:"New clients without rewriting code"},{headline:"Convenient for B2B and B2C",icon:"case",text:"Internal CRM, chat applications, offline utilities, task managers, task trackers, dashboards — you can carry everything in your pocket."},{headline:"Without pain and extra stacks",icon:"convenient",text:"One stack. One language. One project. PHP from start to launch in the App Store."}]}renderElement(e){return p`
            <div class="element">
                <div class="top">
                    <img class="icon" src="/images/icons/${e.icon}.svg" alt="${e.headline}"/>
                    <h5 class="name">${e.headline}</h5>
                </div>
                <p class="text">${e.text}</p>
            </div>
        `}render(){return p`
            <section class="container">
                <div class="left">
                    <div class="wrapper">
                        <slot></slot>
                    </div>
                </div>
                <div class="right">
                    ${this.elements.map(e=>this.renderElement(e))}
                </div>
            </section>
        `}}customElements.define("mobile-development-section",je);class G extends g{static cfg={delay:2e3};static styles=[$,y`
        .container {
            display: flex;
            flex-direction: column;
            margin-bottom: 2em;
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
            z-index: 1;
            position: absolute;
            content: "";
            width: 640px;
            height: 640px;
            background: radial-gradient(50% 50% at 50% 50%, var(--color-text-brand) 0%, var(--color-bg) 100%);
            opacity: 0.1;
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
            font-family: var(--font-title), sans-serif;
            color: var(--color-text-secondary);
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
            color: var(--color-text);
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
        }
        .tech-description {
            color: var(--color-text-secondary);
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
        @media (orientation: portrait) {
            .top {
                flex-direction: column;
                margin: 0 1em;
            }
            .system-edge {
                display: none;
            }
            .wtf {

            }
            .border-top {
                border-color: var(--color-border) !important;
            }
            .full {
                border-color: var(--color-border) !important;
            }
            .half {
                display: none;
                border-color: var(--color-border) !important;
            }
            .half {
                border-left-color: transparent !important;
                border-right-color: transparent !important;
            }
            .systems {
                flex-wrap: wrap;
            }
            .systems > div {
                flex: 34%;
            }
            .technologies {
                flex-direction: column;
            }
            .icon::before {
                width: 95vw;
            }
        }
    `];static properties={activeIndex:{type:Number,state:!0}};constructor(){super(),this.activeIndex=1,this._intervalId=null}connectedCallback(){super.connectedCallback(),this._startAnimation()}disconnectedCallback(){super.disconnectedCallback(),this._stopAnimation()}_startAnimation(){this._intervalId=setInterval(()=>{this.activeIndex=this.activeIndex===4?1:this.activeIndex+1},G.cfg.delay)}_stopAnimation(){this._intervalId&&(clearInterval(this._intervalId),this._intervalId=null)}_getBorderClass(e){const t=[];return this.activeIndex===e&&t.push("border-active"),this.activeIndex===1&&e===2&&t.push("border-top-active"),this.activeIndex===4&&e===3&&t.push("border-top-active"),t.join(" ")}_getSystemClass(e){return this.activeIndex===e?"system system-active":"system"}render(){return p`
            <section class="container">
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
                            <span class="name">Windows</span>
                        </div>
                        <div id="system-2" class="${this._getSystemClass(2)}">
                            <div class="logo"></div>
                            <span class="name">Linux</span>
                        </div>
                        <div id="system-3" class="${this._getSystemClass(3)}">
                            <div class="logo"></div>
                            <span class="name">macOS & iOS</span>
                        </div>
                        <div id="system-4" class="${this._getSystemClass(4)}">
                            <div class="logo"></div>
                            <span class="name">Android</span>
                        </div>
                        <div class="system-edge"></div>
                    </div>
                    <div class="technologies">
                        <div class="technology" id="technology-1">
                            <div class="sticky">
                                <div class="tech-logo"></div>
                                <h6 class="tech-name">Do you write in pure PHP?</h6>
                                <span class="tech-description">Boson loves it too!</span>
                            </div>
                        </div>
                        <div class="technology" id="technology-2">
                            <div class="dots-container"><dots-container></dots-container></div>
                            <div class="sticky">
                                <div class="tech-logo"></div>
                                <h6 class="tech-name">Do you work with Laravel?</h6>
                                <span class="tech-description">Use familiar Blade, Livewire, Inertia or Eloquent for UI and logic. Your routes and controllers work just like on the web.</span>

                            </div>
                        </div>
                        <div class="technology" id="technology-3">
                            <div class="dots-container"><dots-container></dots-container></div>
                            <div style="top: 150px" class="dots-container"><dots-container></dots-container></div>
                            <div class="sticky">
                                <div class="tech-logo"></div>
                                <h6 class="tech-name">Do you prefer Symfony or Yii?</h6>
                                <span class="tech-description">Just plug in Boson. Your components and services are ready to work in Desktop or mobile application.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        `}}customElements.define("nativeness-section",G);class j extends g{static styles=[$,y`
        :host {
            margin-top: calc(var(--landing-layout-gap) * -1);
        }

        .container {
            background-size: 100% auto;
            background: url("/images/right_choice_bg.png") no-repeat top;
            min-height: 200vh;
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

        .top h2 {
            font-size: var(--font-size-h1);
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
            width: 620px;
            transition: transform 0.5s ease;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1em;
        }
        .progress {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 3em;
            align-self: stretch;
            border-top: 1px solid var(--color-border);
            gap: 1em;
        }
        .el {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }
        .dots {
            height: 14px;
            width: 5px;
        }
        .dots.red {
            background-image: url("/images/icons/dots_red.svg");
        }
        .dots.grey {
            background-image: url("/images/icons/dots_grey.svg");
        }
        .progress-text {
            text-transform: uppercase;
            color: var(--color-text-secondary);
            font-family: var(--font-title), sans-serif;
        }
    `];static animationConfig={blockDuration:3e3,transitionDuration:500,animationDistance:800};constructor(){super(),this.animationState={currentStage:0,progressDirection:1,startTime:0,animationId:null},this.elements={topLeft:null,topRight:null,bottomLeft:null,bottomRight:null,progressDots:null}}firstUpdated(){this.elements.topLeft=this.shadowRoot.querySelector(".content-top .content-left .inner"),this.elements.topRight=this.shadowRoot.querySelector(".content-top .content-right .inner"),this.elements.bottomLeft=this.shadowRoot.querySelector(".content-bottom .content-left .inner"),this.elements.bottomRight=this.shadowRoot.querySelector(".content-bottom .content-right .inner"),this.elements.progressDots=this.shadowRoot.querySelectorAll(".dots"),this.startAnimation()}disconnectedCallback(){super.disconnectedCallback(),this.stopAnimation()}startAnimation(){this.animationState.startTime=Date.now(),this.animate()}stopAnimation(){this.animationState.animationId&&(cancelAnimationFrame(this.animationState.animationId),this.animationState.animationId=null)}animate(){const e=j.animationConfig,s=Date.now()-this.animationState.startTime,o=e.blockDuration*4+e.transitionDuration*4,i=s%o,r=e.blockDuration,l=r+e.transitionDuration,a=l+e.blockDuration,d=a+e.transitionDuration,m=d+e.blockDuration,c=m+e.transitionDuration,v=c+e.blockDuration;v+e.transitionDuration;let h=0,f=0;if(i<r)h=i/e.blockDuration*.5,f=0;else if(i<l){const u=(i-r)/e.transitionDuration;h=.5,f=u}else if(i<a)h=.5+(i-l)/e.blockDuration*.5,f=1;else if(i<d){const u=(i-a)/e.transitionDuration;h=1,f=1-u}else if(i<m)h=1-(i-d)/e.blockDuration*.5,f=0;else if(i<c){const u=(i-m)/e.transitionDuration;h=.5,f=u}else if(i<v)h=.5-(i-c)/e.blockDuration*.5,f=1;else{const u=(i-v)/e.transitionDuration;h=0,f=1-u}this.animateElements(f),this.updateProgressBar(h),this.animationState.animationId=requestAnimationFrame(()=>this.animate())}animateElements(e){const s=j.animationConfig.animationDistance;if(!this.elements.topLeft||!this.elements.topRight||!this.elements.bottomLeft||!this.elements.bottomRight)return;const o=e*s,i=Math.min(0,-s+e*s),r=-(e*s),l=Math.max(0,s-e*s);this.elements.topLeft.style.transform=`translateX(${o}px)`,this.elements.topRight.style.transform=`translateX(${i}px)`,this.elements.bottomRight.style.transform=`translateX(${r}px)`,this.elements.bottomLeft.style.transform=`translateX(${l}px)`}updateProgressBar(e){if(!this.elements.progressDots||this.elements.progressDots.length===0)return;const t=this.elements.progressDots.length,s=Math.floor(e*t);this.elements.progressDots.forEach((o,i)=>{i<s?(o.classList.remove("grey"),o.classList.add("red")):(o.classList.remove("red"),o.classList.add("grey"))})}render(){return p`
            <section class="container">
                <div class="top">
                    <h2>
                        Why is Boson PHP</br>
                        <span class="red">the right choice</span> </br>
                        for you?
                    </h2>
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
                                <p>
                                    No need PHP, and that's all you need. Write
                                    code once and your app is available everywhere.
                                </p>

                                <boson-button href="/">
                                    Read More
                                </boson-button>
                            </div>
                        </div>
                        <div class="sep"></div>
                        <div class="content-right">
                            <div class="inner">
                                <p>
                                    No need to learn other languages! You already
                                    know PHP, and that's all you need. Write code
                                    once for the Web and create native apps on Windows,
                                    macOS, Linux, Android, and iOS. The same code,
                                    and your app is available everywhere.
                                </p>

                                <boson-button href="/">
                                    Read More
                                </boson-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress">
                    <div class="el">
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                    </div>
                    <span class="progress-text">STAGE</span>
                    <div class="el">
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                    </div>
                </div>
            </section>
        `}}customElements.define("right-choice-section",j);class Ue extends g{static styles=[$,y`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .content {
            display: flex;
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

        @media (orientation: portrait) {
            .top {
                flex-direction: column;
                margin: 0 1em;
                gap: 3em;
            }
            .dots {
                display: none;
            }
            .inner {
                flex-direction: column;
            }
            .solves {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 3em 2em;
                text-align: center;
                border-bottom: 1px solid var(--color-border);
            }
            .solves:nth-last-child(1) {
                border-bottom: 1px solid transparent;
            }
            .solves > img {
                align-self: center;
            }
        }
    `];render(){return p`
            <section class="container">
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
        `}}customElements.define("solves-section",Ue);class Ne extends g{static styles=[$,y`
        .container {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6em;
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
    `];get slides(){return[{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building irst meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev4",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."}]}render(){return p`
            <section class="container">
                <div class="content">
                    <slider-component .slides=${this.slides}></slider-component>
                </div>
            </section>
        `}}customElements.define("testimonials-section",Ne);class Ye extends g{static properties={};static styles=[$,y`
        :host {
            display: inline-block;
            align-items: center;
            justify-content: center;
        }

        details > summary {
            list-style-type: '';
        }

        details > summary::-webkit-details-marker,
        details > summary::marker {
            display: none;
        }

        .dropdown {
            line-height: var(--height-ui);
            position: relative;
        }

        .dropdown-list {
            position: absolute;
            background: var(--color-bg-layer);
            border: 2px solid var(--color-border);
            padding: 4px;
            display: flex;
            min-width: 200px;
            flex-direction: column;
            flex-wrap: nowrap;
        }

        .dropdown-list::before {
            position: absolute;
            content: "";
            background: var(--color-border);
            top: 10px;
            left: 10px;
            z-index: -1;
            height: 100%;
            width: 100%;
        }

        .dropdown-list ::slotted(boson-button) {
            justify-content: flex-start;
            height: var(--height-ui-small);
            line-height: var(--height-ui-small);
        }

        details:hover > summary ::slotted(boson-button) {
            background: var(--color-border);
        }
    `];constructor(){super()}onMouseEnter(e){e.target.setAttribute("open","open")}onMouseLeave(e){e.target.removeAttribute("open")}render(){return p`
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
        `}}customElements.define("boson-dropdown",Ye);class Xe extends g{static styles=[$,y`
        :host {
            display: block;
            border-bottom: solid 1px var(--color-border);
        }

        .breadcrumbs {
            display: flex;
            justify-content: flex-start;
        }

        ::slotted(.breadcrumb-item) {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        ::slotted(.breadcrumb-item:not(:last-child))::after {
            content: '/';
            color: var(--color-border);
            padding: 0 1em;
        }
    `];constructor(){super()}render(){return p`
            <nav class="breadcrumbs">
                <slot></slot>
            </nav>
        `}}customElements.define("boson-breadcrumbs",Xe);class We extends g{static properties={href:{type:String},external:{type:Boolean},type:{type:String},icon:{type:String},active:{type:Boolean}};static styles=[$,y`
        :host {
            display: inline-block;
            line-height: var(--height-ui);
            height: var(--height-ui);
            justify-content: center;
        }

        .button {
            font-family: var(--font-title), sans-serif;
            font-size: var(--font-size-secondary);
            letter-spacing: 1px;
            color: var(--color-text-button);
            transition-duration: .1s;
            background: var(--color-bg-button);
            text-transform: uppercase;
            height: 100%;
            padding: 0 2em;
            display: flex;
            gap: 1em;
            justify-content: inherit;
            align-items: center;
            white-space: nowrap;
            text-decoration: none;
        }

        span.button {
            cursor: default;
        }

        .button-active,
        a.button:hover {
            text-decoration: none;
            transition-duration: 0s;
            background: var(--color-bg-button-hover);
        }

        .icon {
            aspect-ratio: 1 / 1;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button);
            margin: 0 -1em 0 0;
            user-select: none;
        }

        .icon .img {
            height: var(--font-size);
            margin-top: -2px;
        }

        /** SECONDARY */

        .button.button-secondary {
            background: var(--color-bg-button-secondary);
            color: var(--color-text);
        }

        .button.button-secondary.button-active,
        a.button.button-secondary:hover {
            background: var(--color-bg-button-secondary-hover);
        }

        .button.button-secondary .text {
            color: var(--color-text-button-secondary);
        }

        .button.button-secondary .icon {
            background: var(--color-text-button-secondary);
        }

        /** GHOST */

        .button.button-ghost {
            background: rgba(var(--color-bg-hover), 0);
            color: var(--color-text-secondary );
        }

        .button.button-ghost.button-active,
        a.button.button-ghost:hover {
            background: var(--color-bg-hover);
            color: var(--color-text);
        }

        .button.button-ghost .text {
            color: var(--color-text-button-secondary);
        }

        .button.button-ghost .icon {
            background: none;
            margin: 0 -1em 0 -.5em;
        }

        /** OTHER */

        ::slotted(img.logo) {
            height: 50%;
        }
    `];constructor(){super(),this.href="",this.type="primary",this.icon="",this.external=!1,this.active=!1}render(){return this.href===""?p`
                <span class="button button-${this.type} ${this.active?"button-active":""}">
                    <slot></slot>

                    <span class="icon" style="${this.icon===""?"display:none":""}">
                        <img class="img" src="${this.icon}" alt="arrow" />
                    </span>
                </span>
            `:p`
            <a href="${this.href}"
               class="button button-${this.type} ${this.active?"button-active":""}"
               target="${this.external?"_blank":"_self"}">
                <slot></slot>

                <span class="icon" style="${this.icon===""?"display:none":""}">
                    <img class="img" src="${this.icon}" alt="arrow" />
                </span>
            </a>
        `}}customElements.define("boson-button",We);class Fe extends g{static styles=[$,y`
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
    `];render(){return p`
            <div class="container">
                <div class="inner">
                    <div class="top left"></div>
                    <div class="top right"></div>
                    <div class="bottom left"></div>
                    <div class="bottom right"></div>
                </div>
            </div>
        `}}customElements.define("dots-container",Fe);class Ve extends g{static styles=[y`
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
            text-transform: uppercase;
            font-family: var(--font-title), sans-serif;
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

        @media (orientation: portrait) {
            .dots-left, .dots-right, .holder {
                display: none;
            }
            .top {
                flex-direction: row-reverse;
                flex-wrap: wrap;
            }
            .top > a {
                background: red;
            }
            ::slotted(a) {
                width: unset;
                flex: 34%;
            }
            .bottom {
                flex-direction: column-reverse;
            }
            ::slotted(.social) {
                flex: 21%;
            }
            [name="secondary-link"]::slotted(a) {
                flex: 1;
                padding: 1.5em 0;
                border-bottom: 1px solid var(--color-border);
            }
            .copyright {
                padding: 1.5em 0;
                margin-left: 0;
                text-align: center;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .dots-main {
                flex: 1;
                min-width: 90vw;
                height: 100px;
                border-top: 1px solid var(--color-border);
                border-bottom: 1px solid var(--color-border);
            }
        }
    `];render(){return p`
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
        `}}customElements.define("boson-footer",Ve);class Ze extends g{static properties={isScrolled:{type:Boolean}};static styles=[y`
        :host {
            --header-height: 100px;
            --header-height-scrolled: 70px;
        }

        header {
            height: var(--header-height, 100px);
            line-height: var(--header-height, 100px);
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

        header.scrolled {
            height: var(--header-height-scrolled, 70px);
            line-height: var(--header-height-scrolled, 70px);
        }

        .header-padding {
            width: 100%;
            height: var(--header-height, 100px);
        }

        .dots,
        ::slotted(*) {
            height: 100% !important;
            max-height: 100% !important;
            line-height: inherit !important;
        }

        ::slotted(boson-dropdown) {
            display: flex;
        }

        ::slotted(.logo) {
            border-right: solid 1px var(--color-border);
        }

        .dots:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .nav {
            flex: 1;
            padding: 0 3em;
            display: flex;
            gap: 1em;
            border-right: 1px solid var(--color-border);
            align-self: stretch;
            align-items: center;
        }

        .aside {
            display: flex;
        }

        .aside ::slotted(*) {
            border-right: 1px solid var(--color-border) !important;
        }

        @media (orientation: portrait) {
            .dots {
                display: none;
            }

            .nav {
                display: none;
            }

            .aside {
                display: none;
            }
        }
    `];constructor(){super(),this.isScrolled=!1,this.handleScroll=this.handleScroll.bind(this)}connectedCallback(){super.connectedCallback(),window.addEventListener("scroll",this.handleScroll),this.handleScroll()}disconnectedCallback(){super.disconnectedCallback(),window.removeEventListener("scroll",this.handleScroll)}handleScroll(){const e=window.pageYOffset||document.documentElement.scrollTop;this.isScrolled=e>0}render(){return p`
            <header class="${this.isScrolled?"scrolled":""}">
                <div class="dots">
                    <dots-container></dots-container>
                </div>

                <slot name="logo"></slot>

                <div class="nav">
                    <slot></slot>
                </div>

                <aside class="aside">
                    <slot name="aside"></slot>
                </aside>

                <div class="dots">
                    <dots-container></dots-container>
                </div>
            </header>
            <div class="header-padding"></div>
        `}}customElements.define("boson-header",Ze);class Je extends g{static properties={content:{type:Array},openIndex:{type:Number}};static styles=[$,y`
        .accordion {
            display: flex;
            flex: 1;
            min-height: 400px;
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
            box-sizing: border-box !important;
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
            line-height: 1.75;
        }

        .number {
            color: var(--color-text-brand);
            transition-duration: 0.2s;
            font-size: var(--font-size-h4);
            font-family: var(--font-mono), monospace;
            font-weight: 600;
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
    `];constructor(){super(),this.content=[],this.openIndex=0}handleElementClick(e){this.openIndex=e}renderElement(e,t){const s=this.openIndex===t;return p`
            <div
                class="element ${s?"elementOpen":"elementClosed"}"
                @click=${()=>this.handleElementClick(t)}
            >
                <div class="elementContent">
                    ${s?p`
                        <div class="openTop">
                            <span class="number">0${t+1}</span>
                            <h4 class="headline">${e.headline}</h4>
                        </div>
                    `:p`
                        <div class="closedTop">
                            <span class="number">0${t+1}</span>
                        </div>
                    `}

                    ${s?p`
                        <div class="content">
                            <p class="text">${e.text}</p>
                        </div>
                    `:p`
                        <div class="collapsedContent">
                            <img src="/images/icons/plus.svg" alt="plus"/>
                        </div>
                    `}
                </div>
            </div>
        `}render(){return p`
            <div class="accordion">
                ${this.content.map((e,t)=>this.renderElement(e,t))}
            </div>
        `}}customElements.define("horizontal-accordion",Je);class Ge extends g{static properties={slides:{type:Array},currentIndex:{type:Number},slidesPerView:{type:Number}};static styles=[$,y`
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

        .comment {
            color: var(--color-text-secondary);
        }

        .quote {
            align-self: flex-start;
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
            font-size: var(--font-size);
            font-weight: 500;
        }

        .role {
            color: var(--color-text-brand);
            font-size: var(--font-size-secondary);
            font-family: var(--font-title), sans-serif;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0;
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
    `];constructor(){super(),this.slides=[],this.currentIndex=0,this.slidesPerView=1,this.autoplayInterval=null}connectedCallback(){super.connectedCallback(),this.updateSlidesPerView(),this.startAutoplay(),window.addEventListener("resize",this.updateSlidesPerView.bind(this))}disconnectedCallback(){super.disconnectedCallback(),this.stopAutoplay(),window.removeEventListener("resize",this.updateSlidesPerView.bind(this))}updateSlidesPerView(){this.slidesPerView=window.innerWidth>=768?3:1,this.requestUpdate()}startAutoplay(){this.stopAutoplay(),this.autoplayInterval=setInterval(()=>{this.slideNext()},3e3)}stopAutoplay(){this.autoplayInterval&&(clearInterval(this.autoplayInterval),this.autoplayInterval=null)}slidePrev(){this.currentIndex=this.currentIndex<=0?this.slides.length-this.slidesPerView:this.currentIndex-1,this.requestUpdate()}slideNext(){this.currentIndex=this.currentIndex>=this.slides.length-this.slidesPerView?0:this.currentIndex+1,this.requestUpdate()}getTransform(){const e=100/this.slidesPerView;return`translateX(-${this.currentIndex*e}%)`}renderSlide(e,t){return p`
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
        `}render(){return p`
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
        `}}customElements.define("slider-component",Ge);class Ke extends g{static styles=[$,y`
        .container {
            display: flex;
            gap: 1em;
            justify-content: center;
            align-items: center;
        }

        .img {
            height: 16px;
            user-select: none;
        }
    `];render(){return p`
            <div class="container">
                <img class="img" src="/images/icons/subtitle.svg" alt="subtitle"/>

                <h6 class="name">
                    <slot></slot>
                </h6>
            </div>
        `}}customElements.define("boson-subtitle",Ke);class Qe extends g{static styles=[$,y`
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle-wrapper {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            aspect-ratio: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dot-container {
            width: 100%;
            height: 100%;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .square {
            position: absolute;
            transition: opacity 0.5s ease;
            opacity: 1;
            will-change: transform;
        }

        .square.outer {
            background: #8B8B8B;
        }

        .square.inner {
            background: #F93904;
        }

        .square.dimmed {
            opacity: 0.1;
            border-radius: 50%;
        }

        @media (max-aspect-ratio: 1/1) {
            .circle-wrapper {
                width: 100%;
                height: auto;
            }
        }

        @media (min-aspect-ratio: 1/1) {
            .circle-wrapper {
                width: auto;
                height: 100%;
            }
        }
    `];constructor(){super(),this.squares=[],this.squareData=[],this.animationIntervals=[],this.mouseX=0,this.mouseY=0,this.targetMouseX=0,this.targetMouseY=0,this.containerRect=null,this.animationFrame=null,this.isMouseOver=!1,this.config={outerRadius:260,innerRadius:60,gapBetweenCircles:10,outerLayers:9,innerLayers:5,squareSize:4,squareSpacing:10,outerColor:"#8B8B8B",innerColor:"#F93904",baseSize:550,mouseRadius:150,animationStrength:25,smoothing:.5}}firstUpdated(e){this.createSquares(),this.startAnimations(),this.setupMouseTracking(),this.updateContainerRect(),this.animate(),this.resizeObserver=new ResizeObserver(()=>{this.updateContainerRect()}),this.resizeObserver.observe(this.shadowRoot.querySelector(".dot-container"))}disconnectedCallback(){super.disconnectedCallback(),this.animationIntervals.forEach(e=>clearInterval(e)),this.removeMouseTracking(),this.animationFrame&&cancelAnimationFrame(this.animationFrame),this.resizeObserver&&this.resizeObserver.disconnect()}updateContainerRect(){const e=this.shadowRoot.querySelector(".dot-container");e&&(this.containerRect=e.getBoundingClientRect())}setupMouseTracking(){const e=this.shadowRoot.querySelector(".container");e&&(this.handleMouseMove=this.handleMouseMove.bind(this),this.handleMouseLeave=this.handleMouseLeave.bind(this),this.handleMouseEnter=this.handleMouseEnter.bind(this),e.addEventListener("mousemove",this.handleMouseMove),e.addEventListener("mouseleave",this.handleMouseLeave),e.addEventListener("mouseenter",this.handleMouseEnter))}removeMouseTracking(){const e=this.shadowRoot.querySelector(".container");e&&(e.removeEventListener("mousemove",this.handleMouseMove),e.removeEventListener("mouseleave",this.handleMouseLeave),e.removeEventListener("mouseenter",this.handleMouseEnter))}handleMouseMove(e){this.containerRect||this.updateContainerRect(),this.targetMouseX=e.clientX-this.containerRect.left,this.targetMouseY=e.clientY-this.containerRect.top+window.scrollY}handleMouseEnter(e){this.isMouseOver=!0,this.containerRect||this.updateContainerRect()}handleMouseLeave(){this.isMouseOver=!1,this.mouseX=-100,this.mouseY=-100,this.updateSquarePositions()}animate(){window.scrollY<window.innerHeight&&(this.isMouseOver?(this.mouseX+=(this.targetMouseX-this.mouseX)*this.config.smoothing,this.mouseY+=(this.targetMouseY-this.mouseY)*this.config.smoothing,this.updateSquarePositions()):(this.mouseX=-1e3,this.mouseY=-1e3,this.resetSquaresToOriginal())),this.animationFrame=requestAnimationFrame(()=>this.animate())}resetSquaresToOriginal(){this.squareData.forEach((e,t)=>{const s=this.squares[t],i=s.style.transform.match(/calc\(-50% \+ ([-\d.]+)px\), calc\(-50% \+ ([-\d.]+)px\)/);if(i){const r=parseFloat(i[1])||0,l=parseFloat(i[2])||0,a=r*(1-this.config.smoothing),d=l*(1-this.config.smoothing);Math.abs(a)<.1&&Math.abs(d)<.1?s.style.transform="translate(-50%, -50%)":s.style.transform=`translate(calc(-50% + ${a}px), calc(-50% + ${d}px))`}})}updateSquarePositions(){const e=this.config.mouseRadius*this.config.mouseRadius;this.squareData.forEach((t,s)=>{const o=this.squares[s],i=t.originalX-this.mouseX,r=t.originalY-this.mouseY,l=i*i+r*r;if(l<e&&l>0){const a=Math.sqrt(l),d=(this.config.mouseRadius-a)/this.config.mouseRadius*this.config.animationStrength,m=.7/a,c=i*m,v=r*m,h=c*d,f=v*d;o.style.transform=`translate(calc(-50% + ${h}px), calc(-50% + ${f}px))`}else o.style.transform="translate(-50%, -50%)"})}createSquares(){const e=this.shadowRoot.querySelector(".dot-container");if(!e)return;const t=e.getBoundingClientRect(),s=t.width/2,o=t.height/2,i=Math.min(t.width,t.height)/this.config.baseSize,r=this.config.squareSize*i,l=this.config.squareSpacing*i,a=this.config.outerRadius*i,d=a-(this.config.outerLayers-1)*l;for(let v=0;v<this.config.outerLayers;v++){const h=a-v*l,f=2*Math.PI*h,w=Math.floor(f/l);for(let u=0;u<w;u++){const M=u/w*Math.PI*2,R=s+Math.cos(M)*h,T=o+Math.sin(M)*h,b=document.createElement("div");b.className="square outer",b.style.left=`${R}px`,b.style.top=`${T}px`,b.style.width=`${r}px`,b.style.height=`${r}px`,b.style.transform="translate(-50%, -50%)",e.appendChild(b),this.squares.push(b),this.squareData.push({originalX:R,originalY:T,element:b})}}const m=d-this.config.gapBetweenCircles*i,c=Math.min(this.config.innerRadius*i,m);for(let v=0;v<this.config.innerLayers;v++){const h=c-v*l;if(h<=0)break;if(h<l){const u=document.createElement("div");u.className="square inner",u.style.left=`${s}px`,u.style.top=`${o}px`,u.style.width=`${r}px`,u.style.height=`${r}px`,u.style.transform="translate(-50%, -50%)",e.appendChild(u),this.squares.push(u),this.squareData.push({originalX:s,originalY:o,element:u});break}const f=2*Math.PI*h,w=Math.floor(f/l);for(let u=0;u<w;u++){const M=u/w*Math.PI*2,R=s+Math.cos(M)*h,T=o+Math.sin(M)*h,b=document.createElement("div");b.className="square inner",b.style.left=`${R}px`,b.style.top=`${T}px`,b.style.width=`${r}px`,b.style.height=`${r}px`,b.style.transform="translate(-50%, -50%)",e.appendChild(b),this.squares.push(b),this.squareData.push({originalX:R,originalY:T,element:b})}}}startAnimations(){this.squares.forEach(e=>{Math.random()>.96&&e.classList.add("dimmed");const t=setInterval(()=>{Math.random()>.3&&e.classList.toggle("dimmed")},500+Math.random()*3e3);this.animationIntervals.push(t)})}render(){return p`
            <div class="container">
                <div class="circle-wrapper">
                    <div class="dot-container"></div>
                </div>
            </div>
        `}}customElements.define("boson-logo",Qe);class et extends g{static styles=[y`
        .landing-layout {
            display: flex;
            flex-direction: column;
            gap: var(--landing-layout-gap);
        }
    `];render(){return p`
            <main class="landing-layout">
                <slot></slot>
            </main>
        `}}customElements.define("boson-landing-layout",et);
