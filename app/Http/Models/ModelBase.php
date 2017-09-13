<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class ModelBase extends Model
{
	/**
	 * Opciones para exportar
	 * @var array
	 */
	protected $smart_exports = [
		[
			'XLSX' => 'Libro Excel',
			#'PDF' => 'Documento PDF',
		],
		[
			'XLS' => 'Excel 93-2003',
			'CSV' => 'Archivo .csv',
			'TXT' => 'Archivo .txt'
		],
	];

	/**
	 * Los atributos que seran visibles en index-datable
	 * @var null|array
	 */
	protected $fields = null;

	/**
	 * Atributos de carga optimizada
	 * @var array
	 */
	protected $eagerLoaders = [];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Obtenemos atributos a incluir en append/appends()
	 * @return array
	 */
	public function getAppendableFields()
	{
		return array_where(array_diff(array_keys($this->getFields()), array_keys($this->getColumnsDefaultsValues())), function ($value, $key) {
			return !str_contains($value, '.');
		});
	}

	/**
	 * Obtenemos atributos para smart-datatable
	 * @return array
	 */
	public function getFields()
	{
		if (!$this->fields) {
			throw new \Exception('Undefined $fields in ' . class_basename($this) . ' model.');
		}
		return $this->fields;
	}

	/**
	 * Obtenemos Eager-Loaders
	 * @return array
	 */
	public function getEagerLoaders()
	{
		return $this->eagerLoaders;
	}

	/**
	 * Obtenemos opciones para exportacion
	 * @return array
	 */
	public function getSmartExports() {
		return $this->smart_exports;
	}

	/**
	 * Accessor - Obtenemos columna 'activo' formateado en texto
	 * @return string
	 */
	public function getActivoTextAttribute()
	{
		return $this->activo ? 'Activo' : 'Inactivo';
	}

	/**
	 * Accessor - Obtenemos columna 'activo' formateado en HTML
	 * @return string
	 */
	public function getActivoSpanAttribute()
	{
		# Retornamos HTML-Element
		$format = new HtmlString('<span class=' . ($this->activo ? 'toast_success' : 'toast_error') . ">&nbsp;$this->activo_text&nbsp;</span>");
		# Si Ajax, retornamos HTML-String
		if (request()->ajax()) {
			return $format->toHtml();
		}
		return $format;
	}

	/**
	 * Obtenemos columnas-defaults de modelo
	 * @return array
	 */
	public function getColumnsDefaultsValues()
	{
		$columns = $this->getConnection()->getDoctrineSchemaManager()->listTableDetails($this->getTable())->getColumns();
		return array_map(function($column) {
			return $column->getDefault();
		}, $columns );
	}
}
