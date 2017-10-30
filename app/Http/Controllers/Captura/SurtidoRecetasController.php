<?php

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\Recetas;
use App\Http\Models\Captura\RecetasDetalle;
use App\Http\Models\Administracion\Usuarios;
use App\Http\Models\Administracion\Medicos;
use App\Http\Models\Administracion\Programas;
use App\Http\Models\Captura\Afiliaciones;
use App\Http\Models\Captura\Areas;
use App\Http\Models\Captura\Diagnosticos;
use App\Http\Models\Captura\SurtidoRecetas;
use App\Http\Models\Captura\SurtidoRecetasDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Milon\Barcode\DNS2D;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Redirect;
use PDF;

class SurtidoRecetasController extends ControllerBase
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SurtidoRecetas $entity)
    {
        $this->entity = $entity;
        $this->localidades = Localidades::select('localidad','id_localidad')->where('tipo',0)->where('id_cliente',135)->where('estatus',1)->get();
        $this->receta = Recetas::select('folio','id_receta')->whereIn('id_estatus_receta',[1,3])->get();
        $this->usuarios = Usuarios::selectRaw("id_usuario, concat(nombre,' ',paterno,' ',materno) as nombre")->get();
        
        $this->medicos = Medicos::all();
        $this->programas = Programas::select('nombre_programa','id_programa')->get();
        $this->areas = Areas::select('area','id_area')->get();
        
        $this->diagnosticos = Diagnosticos::select('diagnostico','id_diagnostico')->get();
        $this->afiliaciones = Afiliaciones::all();
    }

    public function index($company, $attributes = [])
    {
        $attributes = ['where'=>[]];
        return parent::index($company, $attributes);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company, $attributes = [])
    {
        $attributes = $attributes +['dataview'=>[
            'localidades' => $this->localidades->pluck('localidad','id_localidad')->prepend('Selecciona una opcion...',''),
            'recetas' => $this->receta->pluck('folio','id_receta')->prepend('Selecciona una opcion...',''),
            'usuarios' => $this->usuarios->pluck('nombre','id_usuario')->prepend('',''),
        ]];
        return parent::create($company, $attributes);
    }

    public function store(Request $request, $company)
    {
        # ¿Usuario tiene permiso para crear?
        // $this->authorize('create', $this->entity);

        # Validamos request, si falla regresamos pagina
        $this->validate($request, $this->entity->rules);
        
        DB::beginTransaction();
        $id_usuario = !empty(Auth::Id()) ? Auth::Id() : 1;
        $request->request->set('id_usuario_creacion', "$id_usuario"); #dd($request->all());
        $isSuccess = $this->entity->create($request->all());
        
        if($isSuccess) {
            $id = $isSuccess->id_surtido_receta;
            foreach ($request->detalle as $detalle) {
                if(!empty($detalle['cantidad_surtida'])) {
                    $detalle['id_surtido_receta'] = "$id";
                    $isSuccessDet = $isSuccess->detalles()->save(new SurtidoRecetasDetalle($detalle));
                }
            }
            if($isSuccessDet)
                DB::commit();
            else
                DB::rollBack();

            request()->session()->flash('printpdf', $id);
            return redirect(companyRoute('index'))->with('printpdf', $id);

        }
        else {
            DB::rollBack();
            return $this->redirect('error_store');
        }
    }

    /**
     * Display the specified resource
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($company, $id, $attributes = [])
    {
        $data = $this->entity->findOrFail($id);
        
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

        return view(currentRouteName('smart'), $dataview+[
            'data' => $data,
            'localidades' => $this->localidades->pluck('localidad','id_localidad')->prepend('Selecciona una opcion...',''),
            'recetas' => $this->receta->pluck('folio','id_receta')->prepend('Selecciona una opcion...',''),
            'usuarios' => $this->usuarios->pluck('nombre','id_usuario')->prepend('',''),
            
            'medicos' => $this->medicos->pluck('nombre_completo','id_medico')->prepend('',''),
            'programas' => $this->programas->pluck('nombre_programa','id_programa')->prepend('',''),
            'areas' => $this->areas->pluck('area','id_area')->prepend('',''),
            'diagnosticos' => $this->diagnosticos->pluck('diagnostico','id_diagnostico')->prepend('',''),
            'afiliaciones' => $this->afiliaciones->pluck('full_name','id_afiliacion')->prepend('',''),
            'dependientes' => $this->afiliaciones->pluck('full_name','id_dependiente')->prepend('',''),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($company, $id, $attributes = [])
    {
        $data = $this->entity->findOrFail($id);
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

        return view(currentRouteName('smart'), $dataview+[
            'data' => $data,
            'localidades' => $this->localidades->pluck('localidad','id_localidad')->prepend('Selecciona una opcion...',''),
            'recetas' => $this->receta->pluck('folio','id_receta')->prepend('Selecciona una opcion...',''),
            'usuarios' => $this->usuarios->pluck('nombre','id_usuario')->prepend('',''),
        ]);
    }

    public function imprimir($company,$id){
        $data = SurtidoRecetas::find($id);
        $qr = DNS2D::getBarcodePNG(asset(companyAction('show',['id'=>$data->id_surtido_receta])), "QRCODE");
        $barcode = DNS1D::getBarcodePNG($data->id_surtido_receta, "EAN8");

        $pdf = PDF::setPaper([0,0,1000,200],'landscape')->loadView(currentRouteName('imprimir'), compact('data','qr','barcode'));
            
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        
        return $pdf->stream('solicitud')->header('Content-Type',"application/pdf");
    }
    
    public function getrecetas($company,Request $request)
    {
        $recetas = Recetas::select('folio','id_receta')->whereIn('id_estatus_receta',[1,3])->where('id_localidad',$request->id_localidad)->get();
        $return = $recetas->pluck('folio','id_receta')->prepend('Selecciona una opcion...','')->toJson();
        return $return;
    }
    
    public function getrecetadetalle($company,Request $request)
    {
        $recetas = RecetasDetalle::select('id_receta_detalle','ss_qro_receta_detalle.clave_cliente','c.descripcion','cantidad_pedida','cantidad_surtida',DB::Raw('sum(coalesce(i.quedan,0)) as disponible'),DB::Raw('max(coalesce(c.precio)) as precio'))
            ->where('ss_qro_receta_detalle.id_receta',$request->id_receta)->whereRaw('coalesce(cantidad_surtida * veces_surtidas,0) < coalesce(cantidad_pedida * veces_surtir,0)')
            ->leftJoin('ss_qro_receta as m','m.id_receta','ss_qro_receta_detalle.id_receta')
            ->leftJoin('cat_localidad as l','l.id_localidad','m.id_localidad')
            
            ->leftJoin('cat_cuadro_producto as c', function ($join) {
                $join->on('c.clave_cliente', '=', 'ss_qro_receta_detalle.clave_cliente')
                ->On('c.id_cuadro', '=', 'ss_qro_receta_detalle.id_cuadro')
                ->On('c.id_cliente', '=', 'l.id_cliente');
            })
            
            ->leftJoin('cat_producto_cliente as p', function ($join) {
                $join->on('p.clave_cliente', '=', 'c.clave_cliente')
                ->On('p.id_cuadro', '=', 'c.id_cuadro');
            })
            
            ->leftJoin('inv_existencia as i', function ($join) {
                $join->on('i.id_localidad', '=', 'm.id_localidad')
                    ->On('i.codigo_barras','=','p.codigo_barras')
                    ->On('i.caducidad','>',DB::Raw('now()'));
            })
            ->groupBy('id_receta_detalle','ss_qro_receta_detalle.clave_cliente','c.descripcion','cantidad_pedida','cantidad_surtida')
            ->get();
        
        $return = $recetas->toJson();
        return $return;
    }
}