/**
 * @license
 * Copyright 2019 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const D=globalThis,Y=D.ShadowRoot&&(D.ShadyCSS===void 0||D.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,X=Symbol(),Q=new WeakMap;let ce=class{constructor(e,t,s){if(this._$cssResult$=!0,s!==X)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=e,this.t=t}get styleSheet(){let e=this.o;const t=this.t;if(Y&&e===void 0){const s=t!==void 0&&t.length===1;s&&(e=Q.get(t)),e===void 0&&((this.o=e=new CSSStyleSheet).replaceSync(this.cssText),s&&Q.set(t,e))}return e}toString(){return this.cssText}};const de=n=>new ce(typeof n=="string"?n:n+"",void 0,X),b=(n,...e)=>{const t=n.length===1?n[0]:e.reduce((s,i,o)=>s+(r=>{if(r._$cssResult$===!0)return r.cssText;if(typeof r=="number")return r;throw Error("Value passed to 'css' function must be a 'css' function result: "+r+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(i)+n[o+1],n[0]);return new ce(t,n,X)},fe=(n,e)=>{if(Y)n.adoptedStyleSheets=e.map(t=>t instanceof CSSStyleSheet?t:t.styleSheet);else for(const t of e){const s=document.createElement("style"),i=D.litNonce;i!==void 0&&s.setAttribute("nonce",i),s.textContent=t.cssText,n.appendChild(s)}},ee=Y?n=>n:n=>n instanceof CSSStyleSheet?(e=>{let t="";for(const s of e.cssRules)t+=s.cssText;return de(t)})(n):n;/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const{is:ve,defineProperty:ye,getOwnPropertyDescriptor:xe,getOwnPropertyNames:be,getOwnPropertySymbols:we,getPrototypeOf:$e}=Object,N=globalThis,te=N.trustedTypes,_e=te?te.emptyScript:"",Se=N.reactiveElementPolyfillSupport,I=(n,e)=>n,W={toAttribute(n,e){switch(e){case Boolean:n=n?_e:null;break;case Object:case Array:n=n==null?n:JSON.stringify(n)}return n},fromAttribute(n,e){let t=n;switch(e){case Boolean:t=n!==null;break;case Number:t=n===null?null:Number(n);break;case Object:case Array:try{t=JSON.parse(n)}catch{t=null}}return t}},he=(n,e)=>!ve(n,e),se={attribute:!0,type:String,converter:W,reflect:!1,useDefault:!1,hasChanged:he};Symbol.metadata??=Symbol("metadata"),N.litPropertyMetadata??=new WeakMap;let M=class extends HTMLElement{static addInitializer(e){this._$Ei(),(this.l??=[]).push(e)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(e,t=se){if(t.state&&(t.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(e)&&((t=Object.create(t)).wrapped=!0),this.elementProperties.set(e,t),!t.noAccessor){const s=Symbol(),i=this.getPropertyDescriptor(e,s,t);i!==void 0&&ye(this.prototype,e,i)}}static getPropertyDescriptor(e,t,s){const{get:i,set:o}=xe(this.prototype,e)??{get(){return this[t]},set(r){this[t]=r}};return{get:i,set(r){const c=i?.call(this);o?.call(this,r),this.requestUpdate(e,c,s)},configurable:!0,enumerable:!0}}static getPropertyOptions(e){return this.elementProperties.get(e)??se}static _$Ei(){if(this.hasOwnProperty(I("elementProperties")))return;const e=$e(this);e.finalize(),e.l!==void 0&&(this.l=[...e.l]),this.elementProperties=new Map(e.elementProperties)}static finalize(){if(this.hasOwnProperty(I("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(I("properties"))){const t=this.properties,s=[...be(t),...we(t)];for(const i of s)this.createProperty(i,t[i])}const e=this[Symbol.metadata];if(e!==null){const t=litPropertyMetadata.get(e);if(t!==void 0)for(const[s,i]of t)this.elementProperties.set(s,i)}this._$Eh=new Map;for(const[t,s]of this.elementProperties){const i=this._$Eu(t,s);i!==void 0&&this._$Eh.set(i,t)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(e){const t=[];if(Array.isArray(e)){const s=new Set(e.flat(1/0).reverse());for(const i of s)t.unshift(ee(i))}else e!==void 0&&t.push(ee(e));return t}static _$Eu(e,t){const s=t.attribute;return s===!1?void 0:typeof s=="string"?s:typeof e=="string"?e.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){this._$ES=new Promise(e=>this.enableUpdating=e),this._$AL=new Map,this._$E_(),this.requestUpdate(),this.constructor.l?.forEach(e=>e(this))}addController(e){(this._$EO??=new Set).add(e),this.renderRoot!==void 0&&this.isConnected&&e.hostConnected?.()}removeController(e){this._$EO?.delete(e)}_$E_(){const e=new Map,t=this.constructor.elementProperties;for(const s of t.keys())this.hasOwnProperty(s)&&(e.set(s,this[s]),delete this[s]);e.size>0&&(this._$Ep=e)}createRenderRoot(){const e=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return fe(e,this.constructor.elementStyles),e}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$EO?.forEach(e=>e.hostConnected?.())}enableUpdating(e){}disconnectedCallback(){this._$EO?.forEach(e=>e.hostDisconnected?.())}attributeChangedCallback(e,t,s){this._$AK(e,s)}_$ET(e,t){const s=this.constructor.elementProperties.get(e),i=this.constructor._$Eu(e,s);if(i!==void 0&&s.reflect===!0){const o=(s.converter?.toAttribute!==void 0?s.converter:W).toAttribute(t,s.type);this._$Em=e,o==null?this.removeAttribute(i):this.setAttribute(i,o),this._$Em=null}}_$AK(e,t){const s=this.constructor,i=s._$Eh.get(e);if(i!==void 0&&this._$Em!==i){const o=s.getPropertyOptions(i),r=typeof o.converter=="function"?{fromAttribute:o.converter}:o.converter?.fromAttribute!==void 0?o.converter:W;this._$Em=i;const c=r.fromAttribute(t,o.type);this[i]=c??this._$Ej?.get(i)??c,this._$Em=null}}requestUpdate(e,t,s){if(e!==void 0){const i=this.constructor,o=this[e];if(s??=i.getPropertyOptions(e),!((s.hasChanged??he)(o,t)||s.useDefault&&s.reflect&&o===this._$Ej?.get(e)&&!this.hasAttribute(i._$Eu(e,s))))return;this.C(e,t,s)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(e,t,{useDefault:s,reflect:i,wrapped:o},r){s&&!(this._$Ej??=new Map).has(e)&&(this._$Ej.set(e,r??t??this[e]),o!==!0||r!==void 0)||(this._$AL.has(e)||(this.hasUpdated||s||(t=void 0),this._$AL.set(e,t)),i===!0&&this._$Em!==e&&(this._$Eq??=new Set).add(e))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(t){Promise.reject(t)}const e=this.scheduleUpdate();return e!=null&&await e,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[i,o]of this._$Ep)this[i]=o;this._$Ep=void 0}const s=this.constructor.elementProperties;if(s.size>0)for(const[i,o]of s){const{wrapped:r}=o,c=this[i];r!==!0||this._$AL.has(i)||c===void 0||this.C(i,void 0,o,c)}}let e=!1;const t=this._$AL;try{e=this.shouldUpdate(t),e?(this.willUpdate(t),this._$EO?.forEach(s=>s.hostUpdate?.()),this.update(t)):this._$EM()}catch(s){throw e=!1,this._$EM(),s}e&&this._$AE(t)}willUpdate(e){}_$AE(e){this._$EO?.forEach(t=>t.hostUpdated?.()),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(e)),this.updated(e)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(e){return!0}update(e){this._$Eq&&=this._$Eq.forEach(t=>this._$ET(t,this[t])),this._$EM()}updated(e){}firstUpdated(e){}};M.elementStyles=[],M.shadowRootOptions={mode:"open"},M[I("elementProperties")]=new Map,M[I("finalized")]=new Map,Se?.({ReactiveElement:M}),(N.reactiveElementVersions??=[]).push("2.1.1");/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const V=globalThis,O=V.trustedTypes,ie=O?O.createPolicy("lit-html",{createHTML:n=>n}):void 0,pe="$lit$",A=`lit$${Math.random().toFixed(9).slice(2)}$`,me="?"+A,ke=`<${me}>`,P=document,L=()=>P.createComment(""),T=n=>n===null||typeof n!="object"&&typeof n!="function",J=Array.isArray,Ae=n=>J(n)||typeof n?.[Symbol.iterator]=="function",F=`[ 	
\f\r]`,B=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,oe=/-->/g,ne=/>/g,E=RegExp(`>|${F}(?:([^\\s"'>=/]+)(${F}*=${F}*(?:[^ 	
\f\r"'\`<>=]|("|')|))|$)`,"g"),re=/'/g,ae=/"/g,ue=/^(?:script|style|textarea|title)$/i,Ee=n=>(e,...t)=>({_$litType$:n,strings:e,values:t}),f=Ee(1),q=Symbol.for("lit-noChange"),$=Symbol.for("lit-nothing"),le=new WeakMap,C=P.createTreeWalker(P,129);function ge(n,e){if(!J(n)||!n.hasOwnProperty("raw"))throw Error("invalid template strings array");return ie!==void 0?ie.createHTML(e):e}const Ce=(n,e)=>{const t=n.length-1,s=[];let i,o=e===2?"<svg>":e===3?"<math>":"",r=B;for(let c=0;c<t;c++){const d=n[c];let u,g,m=-1,p=0;for(;p<d.length&&(r.lastIndex=p,g=r.exec(d),g!==null);)p=r.lastIndex,r===B?g[1]==="!--"?r=oe:g[1]!==void 0?r=ne:g[2]!==void 0?(ue.test(g[2])&&(i=RegExp("</"+g[2],"g")),r=E):g[3]!==void 0&&(r=E):r===E?g[0]===">"?(r=i??B,m=-1):g[1]===void 0?m=-2:(m=r.lastIndex-g[2].length,u=g[1],r=g[3]===void 0?E:g[3]==='"'?ae:re):r===ae||r===re?r=E:r===oe||r===ne?r=B:(r=E,i=void 0);const h=r===E&&n[c+1].startsWith("/>")?" ":"";o+=r===B?d+ke:m>=0?(s.push(u),d.slice(0,m)+pe+d.slice(m)+A+h):d+A+(m===-2?c:h)}return[ge(n,o+(n[t]||"<?>")+(e===2?"</svg>":e===3?"</math>":"")),s]};class H{constructor({strings:e,_$litType$:t},s){let i;this.parts=[];let o=0,r=0;const c=e.length-1,d=this.parts,[u,g]=Ce(e,t);if(this.el=H.createElement(u,s),C.currentNode=this.el.content,t===2||t===3){const m=this.el.content.firstChild;m.replaceWith(...m.childNodes)}for(;(i=C.nextNode())!==null&&d.length<c;){if(i.nodeType===1){if(i.hasAttributes())for(const m of i.getAttributeNames())if(m.endsWith(pe)){const p=g[r++],h=i.getAttribute(m).split(A),v=/([.?@])?(.*)/.exec(p);d.push({type:1,index:o,name:v[2],strings:h,ctor:v[1]==="."?Me:v[1]==="?"?qe:v[1]==="@"?Re:U}),i.removeAttribute(m)}else m.startsWith(A)&&(d.push({type:6,index:o}),i.removeAttribute(m));if(ue.test(i.tagName)){const m=i.textContent.split(A),p=m.length-1;if(p>0){i.textContent=O?O.emptyScript:"";for(let h=0;h<p;h++)i.append(m[h],L()),C.nextNode(),d.push({type:2,index:++o});i.append(m[p],L())}}}else if(i.nodeType===8)if(i.data===me)d.push({type:2,index:o});else{let m=-1;for(;(m=i.data.indexOf(A,m+1))!==-1;)d.push({type:7,index:o}),m+=A.length-1}o++}}static createElement(e,t){const s=P.createElement("template");return s.innerHTML=e,s}}function R(n,e,t=n,s){if(e===q)return e;let i=s!==void 0?t._$Co?.[s]:t._$Cl;const o=T(e)?void 0:e._$litDirective$;return i?.constructor!==o&&(i?._$AO?.(!1),o===void 0?i=void 0:(i=new o(n),i._$AT(n,t,s)),s!==void 0?(t._$Co??=[])[s]=i:t._$Cl=i),i!==void 0&&(e=R(n,i._$AS(n,e.values),i,s)),e}class Pe{constructor(e,t){this._$AV=[],this._$AN=void 0,this._$AD=e,this._$AM=t}get parentNode(){return this._$AM.parentNode}get _$AU(){return this._$AM._$AU}u(e){const{el:{content:t},parts:s}=this._$AD,i=(e?.creationScope??P).importNode(t,!0);C.currentNode=i;let o=C.nextNode(),r=0,c=0,d=s[0];for(;d!==void 0;){if(r===d.index){let u;d.type===2?u=new z(o,o.nextSibling,this,e):d.type===1?u=new d.ctor(o,d.name,d.strings,this,e):d.type===6&&(u=new Be(o,this,e)),this._$AV.push(u),d=s[++c]}r!==d?.index&&(o=C.nextNode(),r++)}return C.currentNode=P,i}p(e){let t=0;for(const s of this._$AV)s!==void 0&&(s.strings!==void 0?(s._$AI(e,s,t),t+=s.strings.length-2):s._$AI(e[t])),t++}}class z{get _$AU(){return this._$AM?._$AU??this._$Cv}constructor(e,t,s,i){this.type=2,this._$AH=$,this._$AN=void 0,this._$AA=e,this._$AB=t,this._$AM=s,this.options=i,this._$Cv=i?.isConnected??!0}get parentNode(){let e=this._$AA.parentNode;const t=this._$AM;return t!==void 0&&e?.nodeType===11&&(e=t.parentNode),e}get startNode(){return this._$AA}get endNode(){return this._$AB}_$AI(e,t=this){e=R(this,e,t),T(e)?e===$||e==null||e===""?(this._$AH!==$&&this._$AR(),this._$AH=$):e!==this._$AH&&e!==q&&this._(e):e._$litType$!==void 0?this.$(e):e.nodeType!==void 0?this.T(e):Ae(e)?this.k(e):this._(e)}O(e){return this._$AA.parentNode.insertBefore(e,this._$AB)}T(e){this._$AH!==e&&(this._$AR(),this._$AH=this.O(e))}_(e){this._$AH!==$&&T(this._$AH)?this._$AA.nextSibling.data=e:this.T(P.createTextNode(e)),this._$AH=e}$(e){const{values:t,_$litType$:s}=e,i=typeof s=="number"?this._$AC(e):(s.el===void 0&&(s.el=H.createElement(ge(s.h,s.h[0]),this.options)),s);if(this._$AH?._$AD===i)this._$AH.p(t);else{const o=new Pe(i,this),r=o.u(this.options);o.p(t),this.T(r),this._$AH=o}}_$AC(e){let t=le.get(e.strings);return t===void 0&&le.set(e.strings,t=new H(e)),t}k(e){J(this._$AH)||(this._$AH=[],this._$AR());const t=this._$AH;let s,i=0;for(const o of e)i===t.length?t.push(s=new z(this.O(L()),this.O(L()),this,this.options)):s=t[i],s._$AI(o),i++;i<t.length&&(this._$AR(s&&s._$AB.nextSibling,i),t.length=i)}_$AR(e=this._$AA.nextSibling,t){for(this._$AP?.(!1,!0,t);e!==this._$AB;){const s=e.nextSibling;e.remove(),e=s}}setConnected(e){this._$AM===void 0&&(this._$Cv=e,this._$AP?.(e))}}class U{get tagName(){return this.element.tagName}get _$AU(){return this._$AM._$AU}constructor(e,t,s,i,o){this.type=1,this._$AH=$,this._$AN=void 0,this.element=e,this.name=t,this._$AM=i,this.options=o,s.length>2||s[0]!==""||s[1]!==""?(this._$AH=Array(s.length-1).fill(new String),this.strings=s):this._$AH=$}_$AI(e,t=this,s,i){const o=this.strings;let r=!1;if(o===void 0)e=R(this,e,t,0),r=!T(e)||e!==this._$AH&&e!==q,r&&(this._$AH=e);else{const c=e;let d,u;for(e=o[0],d=0;d<o.length-1;d++)u=R(this,c[s+d],t,d),u===q&&(u=this._$AH[d]),r||=!T(u)||u!==this._$AH[d],u===$?e=$:e!==$&&(e+=(u??"")+o[d+1]),this._$AH[d]=u}r&&!i&&this.j(e)}j(e){e===$?this.element.removeAttribute(this.name):this.element.setAttribute(this.name,e??"")}}class Me extends U{constructor(){super(...arguments),this.type=3}j(e){this.element[this.name]=e===$?void 0:e}}class qe extends U{constructor(){super(...arguments),this.type=4}j(e){this.element.toggleAttribute(this.name,!!e&&e!==$)}}class Re extends U{constructor(e,t,s,i,o){super(e,t,s,i,o),this.type=5}_$AI(e,t=this){if((e=R(this,e,t,0)??$)===q)return;const s=this._$AH,i=e===$&&s!==$||e.capture!==s.capture||e.once!==s.once||e.passive!==s.passive,o=e!==$&&(s===$||i);i&&this.element.removeEventListener(this.name,this,s),o&&this.element.addEventListener(this.name,this,e),this._$AH=e}handleEvent(e){typeof this._$AH=="function"?this._$AH.call(this.options?.host??this.element,e):this._$AH.handleEvent(e)}}class Be{constructor(e,t,s){this.element=e,this.type=6,this._$AN=void 0,this._$AM=t,this.options=s}get _$AU(){return this._$AM._$AU}_$AI(e){R(this,e)}}const Ie=V.litHtmlPolyfillSupport;Ie?.(H,z),(V.litHtmlVersions??=[]).push("3.3.1");const Le=(n,e,t)=>{const s=t?.renderBefore??e;let i=s._$litPart$;if(i===void 0){const o=t?.renderBefore??null;s._$litPart$=i=new z(e.insertBefore(L(),o),o,void 0,t??{})}return i._$AI(n),i};/**
 * @license
 * Copyright 2017 Google LLC
 * SPDX-License-Identifier: BSD-3-Clause
 */const K=globalThis;class y extends M{constructor(){super(...arguments),this.renderOptions={host:this},this._$Do=void 0}createRenderRoot(){const e=super.createRenderRoot();return this.renderOptions.renderBefore??=e.firstChild,e}update(e){const t=this.render();this.hasUpdated||(this.renderOptions.isConnected=this.isConnected),super.update(e),this._$Do=Le(t,this.renderRoot,this.renderOptions)}connectedCallback(){super.connectedCallback(),this._$Do?.setConnected(!0)}disconnectedCallback(){super.disconnectedCallback(),this._$Do?.setConnected(!1)}render(){return q}}y._$litElement$=!0,y.finalized=!0,K.litElementHydrateSupport?.({LitElement:y});const Te=K.litElementPolyfillSupport;Te?.({LitElement:y});(K.litElementVersions??=[]).push("4.2.1");const He="h1,h2,h3,h4,h5,h6{font-family:var(--font-title),sans-serif;color:var(--color-text);margin:0;padding:0}h1{font-size:var(--font-size-h1);line-height:var(--font-line-height-h1);font-weight:700}h2{font-size:var(--font-size-h2);line-height:var(--font-line-height-h2);font-weight:600}h3{font-size:var(--font-size-h3);line-height:var(--font-line-height-h3);font-weight:500}h4{font-size:var(--font-size-h4);line-height:var(--font-line-height-h4);font-weight:500}h5{font-size:var(--font-size-h5);line-height:var(--font-line-height-h5);text-transform:uppercase;font-weight:400}h6{font-size:var(--font-size-h6);line-height:var(--font-line-height-h6);text-transform:uppercase;font-weight:400}pre,code{font-family:var(--font-mono),monospace}.description{color:var(--color-text-secondary)}a{color:inherit;text-decoration:none}*{box-sizing:border-box}@media (orientation: portrait){h1{font-size:5rem}h2{font-size:clamp(3rem,1vw + 3.5rem,5rem)}h3{font-size:max(2rem,min(2rem + 1vw,5rem))}h4{font-size:max(1.5rem,min(2rem + 1vw,2.25rem))}p{font-size:1.25rem}}",w=de(He);class ze extends y{static properties={href:{type:String},type:{type:String},icon:{type:String}};static styles=[w,b`
        .button {
            font-family: var(--font-title), sans-serif;
            letter-spacing: 1px;
            color: var(--color-text-button);
            transition-duration: 0.2s;
            background: var(--color-bg-button);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 0 2em;
            text-transform: uppercase;
            line-height: 56px;
            height: 56px;
            white-space: nowrap;
        }

        .button:hover {
            background: var(--color-bg-button-hover);
        }

        .icon {
            aspect-ratio: 1 / 1;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button);
            margin: 0 -1em 0 -.5em;
        }

        .button.button-secondary {
            background: var(--color-bg-button-secondary);
            color: var(--color-text);
        }

        .button.button-secondary:hover {
            background: var(--color-bg-button-secondary-hover);
        }

        .button.button-secondary .text {
            color: var(--color-text-button-secondary);
        }

        .button.button-secondary .icon {
            background: var(--color-text-button-secondary);
        }
    `];constructor(){super(),this.href="/",this.type="primary",this.icon=""}render(){return f`
            <a href="${this.href}" class="button button-${this.type}">
                <slot></slot>

                <span class="icon" style="${this.icon===""?"display:none":""}">
                    <img class="img" src="${this.icon}" alt="arrow" />
                </span>
            </a>
        `}}customElements.define("button-primary",ze);class De extends y{static properties={href:{type:String},text:{type:String}};static styles=[w,b`
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
    `];constructor(){super(),this.href="/",this.text=""}render(){return f`
            <a href="${this.href}" class="button">
                <span class="text">
                    ${this.text}
                    <slot></slot>
                </span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_secondary.svg" alt="arrow_secondary"/>
                </div>
            </a>
        `}}customElements.define("button-secondary",De);class G extends y{static styles=[w,b`
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
    `];render(){return console.log(window.s=G.styles),f`
            <section class="container">
                <div class="wrapper">
                    <div class="text">
                        <slot></slot>
                    </div>

                    <slot name="footer"></slot>
                </div>
            </section>
        `}}customElements.define("call-to-action-section",G);class Oe extends y{static styles=[w,b`
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

        .headlines h1 {
            color: var(--color-text-brand);
        }

        .description {
            width: 80%;
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
    `];render(){return f`
            <section class="container">
                <div class="top">
                    <div class="text">
                        <div class="headlines">
                            <h1>Go Native. </br><span class="white">Stay PHP</span></h1>
                        </div>
                        <p class="description">Turn your PHP project into cross-platform, compact, fast, native
                            applications for Windows, macOS, Linux, Android and iOS.</p>
                        <div class="buttons">
                            <button-primary href="/" icon="/images/icons/arrow_primary.svg">
                                Try Boson for Free
                            </button-primary>

                            <button-primary type="secondary" href="/" icon="/images/icons/arrow_secondary.svg">
                                Watch Presentation
                            </button-primary>
                        </div>
                    </div>
                    <div class="img">
                        <div class="logo-container">
<!--                            <logo-component></logo-component>-->
                            <logo-animated-transform-component></logo-animated-transform-component>
<!--                            <logo-animated-opacity-component></logo-animated-opacity-component>-->
                        </div>
                    </div>
                </div>

                <aside class="bottom">
                    <a href="#nativeness" class="discover">
                        <span class="discover-container">
                            <span class="discover-text">Discover more about boson</span>
                            <img class="discover-icon" src="/images/icons/arrow_down.svg" alt="arrow_down"/>
                        </span>
                    </a>
                </aside>
            </section>
        `}}customElements.define("hero-section",Oe);class je extends y{static styles=[w,b`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            margin: 0 auto;
            max-width: var(--width-max);
            width: var(--width-content);
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
    `];get content(){return[{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a falications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson antly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance."},{headline:"Saucer: The Core of Performance",text:"At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create and resource consumption, significantly outperforming Electron in terms of performance."}]}render(){return f`
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
        `}}customElements.define("how-it-works-section",je);class Ne extends y{static styles=[w,b`
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
    `];get elements(){return[{text:"For many businesses, mobile devices are the main audience segment. Web applications are good. Desktop clients are great. Mobile applications are wonderful.",icon:"rocket",headline:"Reaching new audiences"},{text:"The same PHP code — but now it works on a mobile device. Budget savings and faster launch.",icon:"clients",headline:"New clients without rewriting code"},{headline:"Convenient for B2B and B2C",icon:"case",text:"Internal CRM, chat applications, offline utilities, task managers, task trackers, dashboards — you can carry everything in your pocket."},{headline:"Without pain and extra stacks",icon:"convenient",text:"One stack. One language. One project. PHP from start to launch in the App Store."}]}renderElement(e){return f`
            <div class="element">
                <div class="top">
                    <img class="icon" src="/images/icons/${e.icon}.svg" alt="${e.headline}"/>
                    <h5 class="name">${e.headline}</h5>
                </div>
                <p class="text">${e.text}</p>
            </div>
        `}render(){return f`
            <section class="container">
                <div class="left">
                    <div class="wrapper">
                        <subtitle-component name="Mobile Development"></subtitle-component>
                        <div class="headline">
                            <h2>Expand Your Business Horizons: <span class="red">PHP Mobile Apps</span></h2>
                        </div>
                        <p class="description">With Boson PHP Mobile, you can run your PHP app on Android and iOS -
                            without learning Swift, Kotlin or React Native.</p>
                        <button-primary href="/">Read More</button-primary>
                    </div>
                </div>
                <div class="right">
                    ${this.elements.map(e=>this.renderElement(e))}
                </div>
            </section>
        `}}customElements.define("mobile-development-section",Ne);class Z extends y{static cfg={delay:2e3};static styles=[w,b`
        .container {
            display: flex;
            flex-direction: column;
            margin-bottom: 2em;
        }

        .top {
            display: flex;
            margin: 0 auto;
            gap: 3em;
            max-width: var(--width-max);
            width: var(--width-content);
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
            justify-content: flex-end;
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
    `];static properties={activeIndex:{type:Number,state:!0}};constructor(){super(),this.activeIndex=1,this._intervalId=null}connectedCallback(){super.connectedCallback(),this._startAnimation()}disconnectedCallback(){super.disconnectedCallback(),this._stopAnimation()}_startAnimation(){this._intervalId=setInterval(()=>{this.activeIndex=this.activeIndex===4?1:this.activeIndex+1},Z.cfg.delay)}_stopAnimation(){this._intervalId&&(clearInterval(this._intervalId),this._intervalId=null)}_getBorderClass(e){const t=[];return this.activeIndex===e&&t.push("border-active"),this.activeIndex===1&&e===2&&t.push("border-top-active"),this.activeIndex===4&&e===3&&t.push("border-top-active"),t.join(" ")}_getSystemClass(e){return this.activeIndex===e?"system system-active":"system"}render(){return f`
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
        `}}customElements.define("nativeness-section",Z);class j extends y{static styles=[w,b`
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
    `];static animationConfig={blockDuration:3e3,transitionDuration:500,animationDistance:800};constructor(){super(),this.animationState={currentStage:0,progressDirection:1,startTime:0,animationId:null},this.elements={topLeft:null,topRight:null,bottomLeft:null,bottomRight:null,progressDots:null}}firstUpdated(){this.elements.topLeft=this.shadowRoot.querySelector(".content-top .content-left .inner"),this.elements.topRight=this.shadowRoot.querySelector(".content-top .content-right .inner"),this.elements.bottomLeft=this.shadowRoot.querySelector(".content-bottom .content-left .inner"),this.elements.bottomRight=this.shadowRoot.querySelector(".content-bottom .content-right .inner"),this.elements.progressDots=this.shadowRoot.querySelectorAll(".dots"),this.startAnimation()}disconnectedCallback(){super.disconnectedCallback(),this.stopAnimation()}startAnimation(){this.animationState.startTime=Date.now(),this.animate()}stopAnimation(){this.animationState.animationId&&(cancelAnimationFrame(this.animationState.animationId),this.animationState.animationId=null)}animate(){const e=j.animationConfig,s=Date.now()-this.animationState.startTime,i=e.blockDuration*4+e.transitionDuration*4,o=s%i,r=e.blockDuration,c=r+e.transitionDuration,d=c+e.blockDuration,u=d+e.transitionDuration,g=u+e.blockDuration,m=g+e.transitionDuration,p=m+e.blockDuration;p+e.transitionDuration;let h=0,v=0;if(o<r)h=o/e.blockDuration*.5,v=0;else if(o<c){const a=(o-r)/e.transitionDuration;h=.5,v=a}else if(o<d)h=.5+(o-c)/e.blockDuration*.5,v=1;else if(o<u){const a=(o-d)/e.transitionDuration;h=1,v=1-a}else if(o<g)h=1-(o-u)/e.blockDuration*.5,v=0;else if(o<m){const a=(o-g)/e.transitionDuration;h=.5,v=a}else if(o<p)h=.5-(o-m)/e.blockDuration*.5,v=1;else{const a=(o-p)/e.transitionDuration;h=0,v=1-a}this.animateElements(v),this.updateProgressBar(h),this.animationState.animationId=requestAnimationFrame(()=>this.animate())}animateElements(e){const s=j.animationConfig.animationDistance;if(!this.elements.topLeft||!this.elements.topRight||!this.elements.bottomLeft||!this.elements.bottomRight)return;const i=e*s,o=Math.min(0,-s+e*s),r=-(e*s),c=Math.max(0,s-e*s);this.elements.topLeft.style.transform=`translateX(${i}px)`,this.elements.topRight.style.transform=`translateX(${o}px)`,this.elements.bottomRight.style.transform=`translateX(${r}px)`,this.elements.bottomLeft.style.transform=`translateX(${c}px)`}updateProgressBar(e){if(!this.elements.progressDots||this.elements.progressDots.length===0)return;const t=this.elements.progressDots.length,s=Math.floor(e*t);this.elements.progressDots.forEach((i,o)=>{o<s?(i.classList.remove("grey"),i.classList.add("red")):(i.classList.remove("red"),i.classList.add("grey"))})}render(){return f`
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
                                <p>No need PHP, and that's all you need. Write code once and your app is available everywhere.</p>
                                <button-secondary href="/">
                                    Read More
                                </button-secondary>
                            </div>
                        </div>
                        <div class="sep"></div>
                        <div class="content-right">
                            <div class="inner">
                                <p>No need to learn other languages! You already know PHP, and that's all you need. Write code once for the Web and create native apps on Windows, macOS, Linux, Android, and iOS. The same code, and your app is available everywhere.</p>
                                <button-primary href="/">Read More</button-primary>
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
        `}}customElements.define("right-choice-section",j);class Ue extends y{static styles=[w,b`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            margin: 0 auto;
            max-width: var(--width-max);
            width: var(--width-content);
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
            margin: .4em 0;
        }

        .el p {
            padding: 0;
            margin: 0;
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
    `];render(){return f`
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
        `}}customElements.define("solves-section",Ue);class Fe extends y{static styles=[w,b`
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
    `];get slides(){return[{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building irst meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev4",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."},{name:"Alex Bondareev",pfp:"img.png",role:"Co-founder, Boson PHP",comment:"Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."}]}render(){return f`
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
        `}}customElements.define("testimonials-section",Fe);class We extends y{static properties={href:{type:String},external:{type:Boolean}};static styles=[w,b`
        .button {
            height: inherit;
            font-family: var(--font-title), sans-serif;
            letter-spacing: 1px;
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
    `];constructor(){super(),this.href="/",this.external=!1}render(){return f`
            <a class="button"
               href="${this.href}"
               target="${this.external?"_blank":"_self"}">
                <slot></slot>
            </a>
        `}}customElements.define("boson-header-button",We);class Ye extends y{static properties={};static styles=[w,b`
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

        .dropdown-list {
            position: absolute;
            line-height: 42px;
            background: var(--color-bg-layer);
            border: 2px solid var(--color-border);
            padding: 4px;
            display: flex;
            min-width: 200px;
            flex-direction: column;
            flex-wrap: nowrap;
            margin-top: -20px;
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
    `];constructor(){super()}onMouseEnter(e){e.target.setAttribute("open","open")}onMouseLeave(e){e.target.removeAttribute("open")}render(){return f`
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
        `}}customElements.define("boson-header-dropdown",Ye);class Xe extends y{static properties={href:{type:String},external:{type:Boolean},active:{type:Boolean}};static styles=[w,b`
        .link {
            font-family: var(--font-title), sans-serif;
            letter-spacing: 1px;
            color: var(--color-text-secondary);
            transition-duration: 0.2s;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .link.active,
        .link:hover {
            background: var(--color-bg-hover);
        }

        ::slotted(img) {
            margin-right: 15px;
        }
    `];constructor(){super(),this.href="/",this.external=!1,this.active=!1}render(){return f`
            <a class="link ${this.active?"active":""}"
               href="${this.href}"
               target="${this.external?"_blank":"_self"}">
                <slot></slot>
            </a>
        `}}customElements.define("boson-header-link",Xe);class Ve extends y{static styles=[w,b`
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
    `];render(){return f`
            <div class="container">
                <div class="inner">
                    <div class="top left"></div>
                    <div class="top right"></div>
                    <div class="bottom left"></div>
                    <div class="bottom right"></div>
                </div>
            </div>
        `}}customElements.define("dots-container",Ve);class Je extends y{static styles=[b`
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
    `];render(){return f`
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
        `}}customElements.define("boson-footer",Je);class Ke extends y{static properties={isScrolled:{type:Boolean}};static styles=[b`
        header {
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

        header.scrolled {
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
    `];constructor(){super(),this.isScrolled=!1,this.handleScroll=this.handleScroll.bind(this)}connectedCallback(){super.connectedCallback(),window.addEventListener("scroll",this.handleScroll),this.handleScroll()}disconnectedCallback(){super.disconnectedCallback(),window.removeEventListener("scroll",this.handleScroll)}handleScroll(){const e=window.pageYOffset||document.documentElement.scrollTop;this.isScrolled=e>0}render(){return f`
            <header class="${this.isScrolled?"scrolled":""}">
                <div class="dots">
                    <dots-container></dots-container>
                </div>

                <slot name="logo"></slot>

                <div class="nav">
                    <slot></slot>
                </div>

                <slot class="aside" name="aside"></slot>

                <div class="dots">
                    <dots-container></dots-container>
                </div>
            </header>
            <div class="header-padding"></div>
        `}}customElements.define("boson-header",Ke);class Ge extends y{static properties={content:{type:Array},openIndex:{type:Number}};static styles=[w,b`
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
    `];constructor(){super(),this.content=[],this.openIndex=0}handleElementClick(e){this.openIndex=e}renderElement(e,t){const s=this.openIndex===t;return f`
            <div
                class="element ${s?"elementOpen":"elementClosed"}"
                @click=${()=>this.handleElementClick(t)}
            >
                <div class="elementContent">
                    ${s?f`
                        <div class="openTop">
                            <span class="number">0${t+1}</span>
                            <h4 class="headline">${e.headline}</h4>
                        </div>
                    `:f`
                        <div class="closedTop">
                            <span class="number">0${t+1}</span>
                        </div>
                    `}

                    ${s?f`
                        <div class="content">
                            <p class="text">${e.text}</p>
                        </div>
                    `:f`
                        <div class="collapsedContent">
                            <img src="/images/icons/plus.svg" alt="plus"/>
                        </div>
                    `}
                </div>
            </div>
        `}render(){return f`
            <div class="accordion">
                ${this.content.map((e,t)=>this.renderElement(e,t))}
            </div>
        `}}customElements.define("horizontal-accordion",Ge);class Ze extends y{static properties={slides:{type:Array},currentIndex:{type:Number},slidesPerView:{type:Number}};static styles=[w,b`
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
    `];constructor(){super(),this.slides=[],this.currentIndex=0,this.slidesPerView=1,this.autoplayInterval=null}connectedCallback(){super.connectedCallback(),this.updateSlidesPerView(),this.startAutoplay(),window.addEventListener("resize",this.updateSlidesPerView.bind(this))}disconnectedCallback(){super.disconnectedCallback(),this.stopAutoplay(),window.removeEventListener("resize",this.updateSlidesPerView.bind(this))}updateSlidesPerView(){this.slidesPerView=window.innerWidth>=768?3:1,this.requestUpdate()}startAutoplay(){this.stopAutoplay(),this.autoplayInterval=setInterval(()=>{this.slideNext()},3e3)}stopAutoplay(){this.autoplayInterval&&(clearInterval(this.autoplayInterval),this.autoplayInterval=null)}slidePrev(){this.currentIndex=this.currentIndex<=0?this.slides.length-this.slidesPerView:this.currentIndex-1,this.requestUpdate()}slideNext(){this.currentIndex=this.currentIndex>=this.slides.length-this.slidesPerView?0:this.currentIndex+1,this.requestUpdate()}getTransform(){const e=100/this.slidesPerView;return`translateX(-${this.currentIndex*e}%)`}renderSlide(e,t){return f`
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
        `}render(){return f`
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
        `}}customElements.define("slider-component",Ze);class Qe extends y{static properties={name:{type:String}};static styles=[w,b`
        .container {
            display: flex;
            gap: 1em;
            justify-content: center;
            align-items: center;
        }

    `];constructor(){super(),this.name=""}render(){return f`
            <div class="container">
                <img class="img" src="/images/icons/subtitle.svg" alt="subtitle"/>
                <h6 class="name">${this.name}</h6>
            </div>
        `}}customElements.define("subtitle-component",Qe);let et=class extends y{static styles=[w,b`
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
        }

        .square.outer {
            background: #8B8B8B;
        }

        .square.inner {
            background: #F93904;
        }

        .square.dimmed {
            opacity: 0.1;
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
    `];constructor(){super(),this.squares=[],this.animationIntervals=[],this.config={outerRadius:260,innerRadius:60,gapBetweenCircles:5,outerLayers:9,innerLayers:5,squareSize:4,squareSpacing:12,outerColor:"#8B8B8B",innerColor:"#F93904",baseSize:600}}firstUpdated(){this.createSquares(),this.startAnimations()}disconnectedCallback(){super.disconnectedCallback(),this.animationIntervals.forEach(e=>clearInterval(e))}createSquares(){const e=this.shadowRoot.querySelector(".dot-container");if(!e)return;const t=e.getBoundingClientRect(),s=t.width/2,i=t.height/2,o=Math.min(t.width,t.height)/this.config.baseSize,r=this.config.squareSize*o,c=this.config.squareSpacing*o,d=this.config.outerRadius*o,u=d-(this.config.outerLayers-1)*c;for(let p=0;p<this.config.outerLayers;p++){const h=d-p*c,v=2*Math.PI*h,x=Math.floor(v/c);for(let a=0;a<x;a++){const _=a/x*Math.PI*2,S=s+Math.cos(_)*h,k=i+Math.sin(_)*h,l=document.createElement("div");l.className="square outer",l.style.left=`${S}px`,l.style.top=`${k}px`,l.style.width=`${r}px`,l.style.height=`${r}px`,l.style.transform="translate(-50%, -50%)",e.appendChild(l),this.squares.push(l)}}const g=u-this.config.gapBetweenCircles*o,m=Math.min(this.config.innerRadius*o,g);for(let p=0;p<this.config.innerLayers;p++){const h=m-p*c;if(h<=0)break;if(h<c){const a=document.createElement("div");a.className="square inner",a.style.left=`${s}px`,a.style.top=`${i}px`,a.style.width=`${r}px`,a.style.height=`${r}px`,a.style.transform="translate(-50%, -50%)",e.appendChild(a),this.squares.push(a);break}const v=2*Math.PI*h,x=Math.floor(v/c);for(let a=0;a<x;a++){const _=a/x*Math.PI*2,S=s+Math.cos(_)*h,k=i+Math.sin(_)*h,l=document.createElement("div");l.className="square inner",l.style.left=`${S}px`,l.style.top=`${k}px`,l.style.width=`${r}px`,l.style.height=`${r}px`,l.style.transform="translate(-50%, -50%)",e.appendChild(l),this.squares.push(l)}}}startAnimations(){this.squares.forEach(e=>{Math.random()>.7&&e.classList.add("dimmed");const t=setInterval(()=>{Math.random()>.8&&e.classList.toggle("dimmed")},1e3+Math.random()*2e3);this.animationIntervals.push(t)})}render(){return f`
            <div class="container">
                <div class="circle-wrapper">
                    <div class="dot-container"></div>
                </div>
            </div>
        `}};customElements.define("logo-component",et);let tt=class extends y{static styles=[w,b`
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
            transition: opacity 0.3s ease;
            opacity: 1;
        }

        .square.outer {
            background: #8B8B8B;
        }

        .square.inner {
            background: #F93904;
        }

        .square.dimmed {
            opacity: 0.1;
        }

        .square.mouse-controlled {
            transition: opacity 0.1s ease;
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
    `];constructor(){super(),this.squares=[],this.animationIntervals=[],this.mouseX=-1e3,this.mouseY=-1e3,this.animationFrame=null,this.config={outerRadius:260,innerRadius:60,gapBetweenCircles:5,outerLayers:9,innerLayers:5,squareSize:4,squareSpacing:12,outerColor:"#8B8B8B",innerColor:"#F93904",baseSize:600,mouseRadius:80},this.handleMouseMove=this.handleMouseMove.bind(this),this.handleMouseLeave=this.handleMouseLeave.bind(this),this.updateSquareStates=this.updateSquareStates.bind(this)}firstUpdated(){this.createSquares(),this.startAnimations(),this.addEventListener("mousemove",this.handleMouseMove),this.addEventListener("mouseleave",this.handleMouseLeave)}disconnectedCallback(){super.disconnectedCallback(),this.animationIntervals.forEach(e=>clearInterval(e)),this.removeEventListener("mousemove",this.handleMouseMove),this.removeEventListener("mouseleave",this.handleMouseLeave),this.animationFrame&&cancelAnimationFrame(this.animationFrame)}handleMouseMove(e){const t=this.getBoundingClientRect();this.mouseX=e.clientX-t.left,this.mouseY=e.clientY-t.top,this.animationFrame||(this.animationFrame=requestAnimationFrame(this.updateSquareStates))}handleMouseLeave(){this.mouseX=-1e3,this.mouseY=-1e3,this.updateSquareStates()}updateSquareStates(){this.animationFrame=null;const e=this.shadowRoot.querySelector(".dot-container");if(!e)return;const t=e.getBoundingClientRect(),s=Math.min(t.width,t.height)/this.config.baseSize,i=this.config.mouseRadius*s;this.squares.forEach(o=>{const r=o.getBoundingClientRect(),c=e.getBoundingClientRect(),d=r.left-c.left+r.width/2,u=r.top-c.top+r.height/2,g=this.mouseX-d,m=this.mouseY-u,p=Math.sqrt(g*g+m*m);if(p<i){o.classList.add("mouse-controlled"),o.classList.remove("dimmed");const h=p/i;o.style.opacity=(h*.6).toString(),o.dataset.mouseAffected="true"}else o.classList.remove("mouse-controlled"),o.dataset.mouseAffected==="true"&&(o.style.opacity="",o.dataset.mouseAffected="false",o.dataset.wasDimmed==="true"&&o.classList.add("dimmed"))})}createSquares(){const e=this.shadowRoot.querySelector(".dot-container");if(!e)return;const t=e.getBoundingClientRect(),s=t.width/2,i=t.height/2,o=Math.min(t.width,t.height)/this.config.baseSize,r=this.config.squareSize*o,c=this.config.squareSpacing*o,d=this.config.outerRadius*o,u=d-(this.config.outerLayers-1)*c;for(let p=0;p<this.config.outerLayers;p++){const h=d-p*c,v=2*Math.PI*h,x=Math.floor(v/c);for(let a=0;a<x;a++){const _=a/x*Math.PI*2,S=s+Math.cos(_)*h,k=i+Math.sin(_)*h,l=document.createElement("div");l.className="square outer",l.style.left=`${S}px`,l.style.top=`${k}px`,l.style.width=`${r}px`,l.style.height=`${r}px`,l.style.transform="translate(-50%, -50%)",l.dataset.mouseAffected="false",l.dataset.wasDimmed="false",e.appendChild(l),this.squares.push(l)}}const g=u-this.config.gapBetweenCircles*o,m=Math.min(this.config.innerRadius*o,g);for(let p=0;p<this.config.innerLayers;p++){const h=m-p*c;if(h<=0)break;if(h<c){const a=document.createElement("div");a.className="square inner",a.style.left=`${s}px`,a.style.top=`${i}px`,a.style.width=`${r}px`,a.style.height=`${r}px`,a.style.transform="translate(-50%, -50%)",a.dataset.mouseAffected="false",a.dataset.wasDimmed="false",e.appendChild(a),this.squares.push(a);break}const v=2*Math.PI*h,x=Math.floor(v/c);for(let a=0;a<x;a++){const _=a/x*Math.PI*2,S=s+Math.cos(_)*h,k=i+Math.sin(_)*h,l=document.createElement("div");l.className="square inner",l.style.left=`${S}px`,l.style.top=`${k}px`,l.style.width=`${r}px`,l.style.height=`${r}px`,l.style.transform="translate(-50%, -50%)",l.dataset.mouseAffected="false",l.dataset.wasDimmed="false",e.appendChild(l),this.squares.push(l)}}}startAnimations(){this.squares.forEach(e=>{Math.random()>.7&&(e.classList.add("dimmed"),e.dataset.wasDimmed="true");const t=setInterval(()=>{e.dataset.mouseAffected!=="true"&&Math.random()>.8&&(e.classList.toggle("dimmed"),e.dataset.wasDimmed=e.classList.contains("dimmed")?"true":"false")},1e3+Math.random()*2e3);this.animationIntervals.push(t)})}render(){return f`
            <div class="container">
                <div class="circle-wrapper">
                    <div class="dot-container"></div>
                </div>
            </div>
        `}};customElements.define("logo-animated-opacity-component",tt);class st extends y{static styles=[w,b`
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
    `];constructor(){super(),this.squares=[],this.squareData=[],this.animationIntervals=[],this.mouseX=0,this.mouseY=0,this.targetMouseX=0,this.targetMouseY=0,this.containerRect=null,this.animationFrame=null,this.isMouseOver=!1,this.config={outerRadius:260,innerRadius:60,gapBetweenCircles:5,outerLayers:9,innerLayers:5,squareSize:4,squareSpacing:12,outerColor:"#8B8B8B",innerColor:"#F93904",baseSize:600,mouseRadius:200,animationStrength:15,smoothing:.5}}firstUpdated(e){this.createSquares(),this.startAnimations(),this.setupMouseTracking(),this.updateContainerRect(),this.animate(),this.resizeObserver=new ResizeObserver(()=>{this.updateContainerRect()}),this.resizeObserver.observe(this.shadowRoot.querySelector(".dot-container"))}disconnectedCallback(){super.disconnectedCallback(),this.animationIntervals.forEach(e=>clearInterval(e)),this.removeMouseTracking(),this.animationFrame&&cancelAnimationFrame(this.animationFrame),this.resizeObserver&&this.resizeObserver.disconnect()}updateContainerRect(){const e=this.shadowRoot.querySelector(".dot-container");e&&(this.containerRect=e.getBoundingClientRect())}setupMouseTracking(){const e=this.shadowRoot.querySelector(".container");e&&(this.handleMouseMove=this.handleMouseMove.bind(this),this.handleMouseLeave=this.handleMouseLeave.bind(this),this.handleMouseEnter=this.handleMouseEnter.bind(this),e.addEventListener("mousemove",this.handleMouseMove),e.addEventListener("mouseleave",this.handleMouseLeave),e.addEventListener("mouseenter",this.handleMouseEnter))}removeMouseTracking(){const e=this.shadowRoot.querySelector(".container");e&&(e.removeEventListener("mousemove",this.handleMouseMove),e.removeEventListener("mouseleave",this.handleMouseLeave),e.removeEventListener("mouseenter",this.handleMouseEnter))}handleMouseMove(e){this.containerRect||this.updateContainerRect(),this.targetMouseX=e.clientX-this.containerRect.left,this.targetMouseY=e.clientY-this.containerRect.top}handleMouseEnter(){this.isMouseOver=!0,this.containerRect||this.updateContainerRect()}handleMouseLeave(){this.isMouseOver=!1}animate(){this.isMouseOver?(this.mouseX+=(this.targetMouseX-this.mouseX)*this.config.smoothing,this.mouseY+=(this.targetMouseY-this.mouseY)*this.config.smoothing):this.resetSquaresToOriginal(),this.isMouseOver&&this.updateSquarePositions(),this.animationFrame=requestAnimationFrame(()=>this.animate())}resetSquaresToOriginal(){this.squareData.forEach((e,t)=>{const s=this.squares[t],o=s.style.transform.match(/calc\(-50% \+ ([-\d.]+)px\), calc\(-50% \+ ([-\d.]+)px\)/);if(o){const r=parseFloat(o[1])||0,c=parseFloat(o[2])||0,d=r*(1-this.config.smoothing),u=c*(1-this.config.smoothing);Math.abs(d)<.1&&Math.abs(u)<.1?s.style.transform="translate(-50%, -50%)":s.style.transform=`translate(calc(-50% + ${d}px), calc(-50% + ${u}px))`}})}updateSquarePositions(){const e=this.config.mouseRadius*this.config.mouseRadius;this.squareData.forEach((t,s)=>{const i=this.squares[s],o=t.originalX-this.mouseX,r=t.originalY-this.mouseY,c=o*o+r*r;if(c<e&&c>0){const d=Math.sqrt(c),u=(this.config.mouseRadius-d)/this.config.mouseRadius*this.config.animationStrength,g=1/d,m=o*g,p=r*g,h=m*u,v=p*u;i.style.transform=`translate(calc(-50% + ${h}px), calc(-50% + ${v}px))`}else i.style.transform="translate(-50%, -50%)"})}createSquares(){const e=this.shadowRoot.querySelector(".dot-container");if(!e)return;const t=e.getBoundingClientRect(),s=t.width/2,i=t.height/2,o=Math.min(t.width,t.height)/this.config.baseSize,r=this.config.squareSize*o,c=this.config.squareSpacing*o,d=this.config.outerRadius*o,u=d-(this.config.outerLayers-1)*c;for(let p=0;p<this.config.outerLayers;p++){const h=d-p*c,v=2*Math.PI*h,x=Math.floor(v/c);for(let a=0;a<x;a++){const _=a/x*Math.PI*2,S=s+Math.cos(_)*h,k=i+Math.sin(_)*h,l=document.createElement("div");l.className="square outer",l.style.left=`${S}px`,l.style.top=`${k}px`,l.style.width=`${r}px`,l.style.height=`${r}px`,l.style.transform="translate(-50%, -50%)",e.appendChild(l),this.squares.push(l),this.squareData.push({originalX:S,originalY:k,element:l})}}const g=u-this.config.gapBetweenCircles*o,m=Math.min(this.config.innerRadius*o,g);for(let p=0;p<this.config.innerLayers;p++){const h=m-p*c;if(h<=0)break;if(h<c){const a=document.createElement("div");a.className="square inner",a.style.left=`${s}px`,a.style.top=`${i}px`,a.style.width=`${r}px`,a.style.height=`${r}px`,a.style.transform="translate(-50%, -50%)",e.appendChild(a),this.squares.push(a),this.squareData.push({originalX:s,originalY:i,element:a});break}const v=2*Math.PI*h,x=Math.floor(v/c);for(let a=0;a<x;a++){const _=a/x*Math.PI*2,S=s+Math.cos(_)*h,k=i+Math.sin(_)*h,l=document.createElement("div");l.className="square inner",l.style.left=`${S}px`,l.style.top=`${k}px`,l.style.width=`${r}px`,l.style.height=`${r}px`,l.style.transform="translate(-50%, -50%)",e.appendChild(l),this.squares.push(l),this.squareData.push({originalX:S,originalY:k,element:l})}}}startAnimations(){this.squares.forEach(e=>{Math.random()>.9&&e.classList.add("dimmed");const t=setInterval(()=>{Math.random()>.9&&e.classList.toggle("dimmed")},1e3+Math.random()*2e3);this.animationIntervals.push(t)})}render(){return f`
            <div class="container">
                <div class="circle-wrapper">
                    <div class="dot-container"></div>
                </div>
            </div>
        `}}customElements.define("logo-animated-transform-component",st);class it extends y{static styles=[b`
        .landing-layout {
            display: flex;
            flex-direction: column;
            gap: 8em;
        }
    `];render(){return f`
            <main class="landing-layout">
                <slot></slot>
            </main>
        `}}customElements.define("boson-landing-layout",it);
