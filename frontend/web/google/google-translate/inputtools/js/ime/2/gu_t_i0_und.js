(function() { var d=".",e="\u0964",f="\u0964 ",g="\u0a81",h="\u0a82",k="\u0a83",l="\u0a85",m="\u0a86",p="\u0a87",q="\u0a88",r="\u0a89",t="\u0a8a",u="\u0a8b",v="\u0a8d",w="\u0a8f",x="\u0a90",y="\u0a91",z="\u0a93",A="\u0a94",B="\u0a95",C="\u0a96",D="\u0a97",E="\u0a98",F="\u0a9a",G="\u0a9b",H="\u0a9c",I="\u0a9c\u0acd",J="\u0a9c\u0acd\u0a9e",K="\u0a9d",L="\u0a9f",M="\u0aa0",N="\u0aa1",O="\u0aa2",P="\u0aa3",Q="\u0aa4",R="\u0aa5",S="\u0aa6",aa="\u0aa6\u0ac1",ba="\u0aa6\u0ac1\u0a83",ca="\u0aa7",da="\u0aa8",ea="\u0aaa",
T="\u0aab",fa="\u0aac",ga="\u0aad",ha="\u0aae",ia="\u0aaf",U="\u0ab0",ja="\u0ab2",V="\u0ab3",W="\u0ab5",ka="\u0ab6",la="\u0ab7",ma="\u0ab8",na="\u0ab9",oa="\u0abc",pa="\u0abd",qa="\u0abe",ra="\u0abf",sa="\u0ac0",ta="\u0ac1",ua="\u0ac2",X="\u0ac3",Y="\u0ac4",va="\u0ac5",wa="\u0ac7",xa="\u0ac8",ya="\u0ac9",za="\u0acb",Aa="\u0acc",Ba="\u0ad0",Z="\u0ae0",Ca="\u0ae6",Da="\u0ae7",Ea="\u0ae8",Fa="\u0ae9",Ga="\u0aea",Ha="\u0aeb",Ia="\u0aec",Ja="\u0aed",Ka="\u0aee",La="\u0aef";
function Ma(b,n){var a=/[\u0A80-\u0AFF]+$/i;if(n!=d)return null;var c=b.match(a);return c&&c[0]?(a={back:0},a.text=3<c[0].length?e:d,a):/[ \u00a0\t]$/.test(b.slice(-1))&&b.slice(0,-1).match(a)&&!/\u0964$/.test(b.slice(0,-1))?a={back:1,text:f}:null};google.elements.ime.loadConfig("gu-t-i0-und",function(){var b={"|":e};return{0:0,1:2,2:!0,3:!0,4:!1,5:!1,6:!1,7:!1,8:!1,9:!0,10:!1,28:!1,11:!0,12:!0,13:50,14:6,15:1,16:{".a":[h,v,y,oa,pa,va,ya],0:[Ca],1:[Da],2:[Ea],3:[Fa],4:[Ga],5:[Ha],6:[Ia],7:[Ja],8:[Ka],9:[La],a:[l],aa:[m,qa],ah:[k],ai:[x,xa],am:[g,h],an:[g,h],ao:[W],aum:[Ba],b:[fa],bh:[ga],ch:[F,G],chh:[F,G],d:[N,S,V],dh:[N,O,S,ca,V],dhh:[N,S,V],du:[aa,ba],e:[w,wa],ee:[q,sa],f:[T],g:[D],gh:[E],gn:[J],gy:[J],h:[na],i:[p,ra],j:[H,I],jh:[K],k:[B],
kh:[C],l:[ja,V],m:[ha],n:[P,da],ng:[g,h],o:[z,za],oo:[t,ua],ow:[A,Aa],p:[ea],ph:[T],r:[u,U,X,Y,Z],rh:[N,S,V],ri:[u,U,X,Y,Z],s:[ma],sh:[ka,la],t:[L,Q],th:[L,M,Q,R],thh:[L,Q],tth:[L,Q],u:[r,ta],v:[W],w:[W],y:[ia],z:[K]},19:function(n,a){if(b[a]){var c={back:0};c.text=b[a];return c}return Ma(n,a)},22:/[a-z]/i,27:/[^a-z\u0A80-\u0AFF]/i}}()); })()