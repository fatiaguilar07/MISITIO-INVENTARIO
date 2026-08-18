CREATE TABLE IF NOT EXISTS inventario (
    codigo INT NOT NULL AUTO_INCREMENT,
    nom_producto VARCHAR(255) NOT NULL,
    costo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    porc_venta INT NOT NULL DEFAULT 0,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    Imagen VARCHAR(255) NULL,
    Fecha DATE NULL,
    stock INT NOT NULL DEFAULT 0,
    PRIMARY KEY (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO inventario (nom_producto, costo, porc_venta, precio_venta, Imagen, Fecha, stock)
VALUES
('Producto de prueba', 50.00, 20, 60.00, 'default.jpg', CURDATE(), 10);
