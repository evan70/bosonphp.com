import{p as N}from"./chunk-K2ZEYYM2-DSPSo4MW.js";import{p as B}from"./treemap-75Q7IDZK-SV5UZEO6-DI1-1-9O.js";import{_ as i,g as U,s as q,a as H,b as V,t as Z,q as j,l as C,c as J,F as K,a6 as Q,a8 as X,a9 as z,aa as Y,e as ee,z as te,ab as ae,H as re}from"./app-CRzUT9sW.js";import"./chunk-TGZYFRKZ-BFW9m3Vb.js";var ie=re.pie,D={sections:new Map,showData:!1},h=D.sections,w=D.showData,se=structuredClone(ie),ne=i(()=>structuredClone(se),"getConfig"),oe=i(()=>{h=new Map,w=D.showData,te()},"clear"),le=i(({label:e,value:t})=>{h.has(e)||(h.set(e,t),C.debug(`added new section: ${e}, with value: ${t}`))},"addSection"),ce=i(()=>h,"getSections"),de=i(e=>{w=e},"setShowData"),pe=i(()=>w,"getShowData"),F={getConfig:ne,clear:oe,setDiagramTitle:j,getDiagramTitle:Z,setAccTitle:V,getAccTitle:H,setAccDescription:q,getAccDescription:U,addSection:le,getSections:ce,setShowData:de,getShowData:pe},ge=i((e,t)=>{N(e,t),t.setShowData(e.showData),e.sections.map(t.addSection)},"populateDb"),ue={parse:i(async e=>{const t=await B("pie",e);C.debug(t),ge(t,F)},"parse")},fe=i(e=>`
  .pieCircle{
    stroke: ${e.pieStrokeColor};
    stroke-width : ${e.pieStrokeWidth};
    opacity : ${e.pieOpacity};
  }
  .pieOuterCircle{
    stroke: ${e.pieOuterStrokeColor};
    stroke-width: ${e.pieOuterStrokeWidth};
    fill: none;
  }
  .pieTitleText {
    text-anchor: middle;
    font-size: ${e.pieTitleTextSize};
    fill: ${e.pieTitleTextColor};
    font-family: ${e.fontFamily};
  }
  .slice {
    font-family: ${e.fontFamily};
    fill: ${e.pieSectionTextColor};
    font-size:${e.pieSectionTextSize};
    // fill: white;
  }
  .legend text {
    fill: ${e.pieLegendTextColor};
    font-family: ${e.fontFamily};
    font-size: ${e.pieLegendTextSize};
  }
`,"getStyles"),he=fe,me=i(e=>{const t=[...e.entries()].map(s=>({label:s[0],value:s[1]})).sort((s,o)=>o.value-s.value);return ae().value(s=>s.value)(t)},"createPieArcs"),Se=i((e,t,G,s)=>{C.debug(`rendering pie chart
`+e);const o=s.db,y=J(),T=K(o.getConfig(),y.pie),$=40,n=18,p=4,c=450,m=c,S=Q(t),l=S.append("g");l.attr("transform","translate("+m/2+","+c/2+")");const{themeVariables:a}=y;let[A]=X(a.pieOuterStrokeWidth);A??=2;const _=T.textPosition,g=Math.min(m,c)/2-$,W=z().innerRadius(0).outerRadius(g),M=z().innerRadius(g*_).outerRadius(g*_);l.append("circle").attr("cx",0).attr("cy",0).attr("r",g+A/2).attr("class","pieOuterCircle");const b=o.getSections(),v=me(b),O=[a.pie1,a.pie2,a.pie3,a.pie4,a.pie5,a.pie6,a.pie7,a.pie8,a.pie9,a.pie10,a.pie11,a.pie12],d=Y(O);l.selectAll("mySlices").data(v).enter().append("path").attr("d",W).attr("fill",r=>d(r.data.label)).attr("class","pieCircle");let E=0;b.forEach(r=>{E+=r}),l.selectAll("mySlices").data(v).enter().append("text").text(r=>(r.data.value/E*100).toFixed(0)+"%").attr("transform",r=>"translate("+M.centroid(r)+")").style("text-anchor","middle").attr("class","slice"),l.append("text").text(o.getDiagramTitle()).attr("x",0).attr("y",-400/2).attr("class","pieTitleText");const x=l.selectAll(".legend").data(d.domain()).enter().append("g").attr("class","legend").attr("transform",(r,u)=>{const f=n+p,R=f*d.domain().length/2,I=12*n,L=u*f-R;return"translate("+I+","+L+")"});x.append("rect").attr("width",n).attr("height",n).style("fill",d).style("stroke",d),x.data(v).append("text").attr("x",n+p).attr("y",n-p).text(r=>{const{label:u,value:f}=r.data;return o.getShowData()?`${u} [${f}]`:u});const P=Math.max(...x.selectAll("text").nodes().map(r=>r?.getBoundingClientRect().width??0)),k=m+$+n+p+P;S.attr("viewBox",`0 0 ${k} ${c}`),ee(S,c,k,T.useMaxWidth)},"draw"),ve={draw:Se},ye={parser:ue,db:F,renderer:ve,styles:he};export{ye as diagram};
