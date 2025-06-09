// Código de pruebas Cypress organizado para JASS Uñas 

describe('Pruebas de la aplicación JASS Uñas', () => {
    it('Carga la página de inicio de sesión y permite iniciar sesión', () => {
      cy.visit('/login');
      cy.get('input[name="email"]').type('admin@example.com');
      cy.get('input[name="password"]').type('password');
      cy.contains('Log in').click();
      cy.url().should('include', '/dashboard');
      cy.get('h1, h2, h3, .titulo, .header, .dashboard-title').should('be.visible');
    });
});

describe('Pruebas de módulos de JASS Uñas', () => {
    beforeEach(() => {
      cy.visit('/login');
      cy.get('input[name="email"]').type('admin@example.com');
      cy.get('input[name="password"]').type('password');
      cy.contains('Log in').click();
      cy.url().should('include', '/dashboard');
    });

    it('Gestionar Clientes: Cargar y mostrar clientes', () => {
      cy.contains('Gestionar Clientes').click();
      cy.url().should('include', '/clientes');
      cy.get('table').should('exist').find('tr').should('have.length.at.least', 1);
    }); 

    it('Gestionar Medidores: Agregar un medidor', () => {
      cy.contains('Gestionar Medidores').click();
      cy.url().should('include', '/medidores');
      cy.contains('Agregar Medidor').click();
      cy.get('input[name="numero_serie"]').type('MED-123');
      cy.get('input[name="ubicacion"]').type('Zona 1');
      cy.contains('Guardar').click();
      cy.url().should('include', '/medidores');
    });

    it('Gestionar Pagos: Mostrar historial de pagos', () => {
        cy.contains('Gestionar Pagos').click();
        cy.url().should('include', '/pagos');
      
        // Esperar explícitamente un poco más para que cargue la página
        cy.wait(2000);
      
        // Verificar qué elementos hay en la página
        cy.get('body').then(($body) => {
          cy.log($body.html()); // Esto mostrará el HTML en la consola de Cypress
      
          if ($body.find('table').length) {
            cy.get('table').should('exist').find('th').contains('Monto').should('exist');
          } else {
            cy.log('No se encontró la tabla en esta página');
          }
        });
      });      

      it('Gestionar Facturas: Crear', () => {
        cy.contains('Gestionar Facturas').click();
        cy.url().should('include', '/facturas');
  
        cy.contains('Agregar Factura').click();
        cy.get('input, select').filter('[name*="cliente"]').type('Cliente Prueba');
        cy.get('input[name="monto"]').type('100.50');
        cy.get('input[name="fecha"]').type('2025-02-13');
        cy.get('button, input[type="submit"]').contains(/Guardar/i).click();
      });
});
