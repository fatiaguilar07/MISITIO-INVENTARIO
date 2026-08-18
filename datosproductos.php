<?php

require_once 'conexionf2.php';

class datosProductos
{
    const TABLA = 'inventario';

    private $codproducto = null;
    private $nom_producto = "";
    private $costoproducto = 0.00;
    private $porc_ventapro = 0;
    private $precio_ventapro = 0.00;
    private $imagenpro = "";
    private $stockpro = 0;
    private $fechapro = null;

    public function __construct(
        $codproducto = null,
        $nom_producto = "",
        $costoproducto = 0.00,
        $porc_ventapro = 0,
        $precio_ventapro = 0.00,
        $imagenpro = "",
        $stockpro = 0,
        $fechapro = null
    ) {
        $this->codproducto = $codproducto;
        $this->nom_producto = $nom_producto;
        $this->costoproducto = $costoproducto;
        $this->porc_ventapro = $porc_ventapro;
        $this->precio_ventapro = $precio_ventapro;
        $this->imagenpro = $imagenpro;
        $this->stockpro = $stockpro;
        $this->fechapro = $fechapro;
    }

    public function get_codproducto()
    {
        return $this->codproducto;
    }

    public function get_nom_producto()
    {
        return $this->nom_producto;
    }

    public function get_costoproducto()
    {
        return $this->costoproducto;
    }

    public function get_porc_ventapro()
    {
        return $this->porc_ventapro;
    }

    public function get_precio_ventapro()
    {
        return $this->precio_ventapro;
    }

    public function get_imagenpro()
    {
        return $this->imagenpro;
    }

    public function get_stockpro()
    {
        return $this->stockpro;
    }

    public function get_fechapro()
    {
        return $this->fechapro;
    }

    public function set_codproducto($codproducto)
    {
        $this->codproducto = $codproducto;
    }

    public function set_nom_producto($nom_producto)
    {
        $this->nom_producto = $nom_producto;
    }

    public function set_costoproducto($costoproducto)
    {
        $this->costoproducto = $costoproducto;
    }

    public function set_porc_ventapro($porc_ventapro)
    {
        $this->porc_ventapro = $porc_ventapro;
    }

    public function set_precio_ventapro($precio_ventapro)
    {
        $this->precio_ventapro = $precio_ventapro;
    }

    public function set_imagenpro($imagenpro)
    {
        $this->imagenpro = $imagenpro;
    }

    public function set_stockpro($stockpro)
    {
        $this->stockpro = $stockpro;
    }

    public function set_fechapro($fechapro)
    {
        $this->fechapro = $fechapro;
    }

    public function guardarproducto()
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'INSERT INTO ' . self::TABLA .
            ' (nom_producto, costo, porc_venta, precio_venta, Imagen, Fecha, stock)
             VALUES (:producto, :pcosto, :pporc_venta, :pprecio_venta, :pImagen, :pFecha, :pStock)'
        );

        $consulta->bindParam(':producto', $this->nom_producto);
        $consulta->bindParam(':pcosto', $this->costoproducto);
        $consulta->bindParam(':pporc_venta', $this->porc_ventapro);
        $consulta->bindParam(':pprecio_venta', $this->precio_ventapro);
        $consulta->bindParam(':pImagen', $this->imagenpro);
        $consulta->bindParam(':pFecha', $this->fechapro);
        $consulta->bindParam(':pStock', $this->stockpro);

        $resultado = $consulta->execute();
        $conexion = null;

        return $resultado;
    }

    public function actualizarProducto()
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'UPDATE ' . self::TABLA .
            ' SET nom_producto = :producto,
            costo = :pcosto,
            porc_venta = :pporc_venta,
            precio_venta = :pprecio_venta,
            Imagen = :pImagen,
            Fecha = :pFecha,
            stock = :pStock
            WHERE codigo = :codpro'
        );

        $consulta->bindParam(':producto', $this->nom_producto);
        $consulta->bindParam(':pcosto', $this->costoproducto);
        $consulta->bindParam(':pporc_venta', $this->porc_ventapro);
        $consulta->bindParam(':pprecio_venta', $this->precio_ventapro);
        $consulta->bindParam(':pImagen', $this->imagenpro);
        $consulta->bindParam(':pFecha', $this->fechapro);
        $consulta->bindParam(':pStock', $this->stockpro);
        $consulta->bindParam(':codpro', $this->codproducto, PDO::PARAM_INT);

        $resultado = $consulta->execute();
        $conexion = null;

        return $resultado;
    }

    public static function actualizarStock($v_idpro, $canstock, $nuevacant)
    {
        if (!isset($v_idpro, $canstock, $nuevacant)) {
            return false;
        }

        $nuevo_stock = (int) $canstock + (int) $nuevacant;

        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'UPDATE ' . self::TABLA .
            ' SET stock = :p_stock
             WHERE codigo = :codpro'
        );

        $consulta->bindParam(':p_stock', $nuevo_stock, PDO::PARAM_INT);
        $consulta->bindParam(':codpro', $v_idpro, PDO::PARAM_INT);

        $resultado = $consulta->execute();
        $conexion = null;

        return $resultado;
    }

    public static function todosProductos()
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'SELECT COUNT(*) FROM ' . self::TABLA
        );

        $consulta->execute();

        $registros = $consulta->fetchColumn();
        $conexion = null;

        return $registros;
    }

    public static function listarProductos()
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'SELECT * FROM ' . self::TABLA . ' ORDER BY codigo DESC'
        );

        $consulta->execute();

        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;

        return $registros;
    }

    public static function obtenerPorId($codproducto)
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'SELECT * FROM ' . self::TABLA .
            ' WHERE codigo = :codpro'
        );

        $consulta->bindParam(':codpro', $codproducto, PDO::PARAM_INT);
        $consulta->execute();

        $registros = $consulta->fetch(PDO::FETCH_ASSOC);
        $conexion = null;

        return $registros;
    }

    public static function consultarProductoCod($codproducto)
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'SELECT * FROM ' . self::TABLA .
            ' WHERE codigo = :codpro'
        );

        $consulta->bindParam(':codpro', $codproducto, PDO::PARAM_INT);
        $consulta->execute();

        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;

        return $registros;
    }

    public function eliminarproducto()
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'DELETE FROM ' . self::TABLA .
            ' WHERE codigo = :codpro'
        );

        $consulta->bindParam(':codpro', $this->codproducto, PDO::PARAM_INT);

        $resultado = $consulta->execute();
        $conexion = null;

        return $resultado;
    }
}
?>
