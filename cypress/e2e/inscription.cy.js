describe('inscription spec', () => {
  it('ok', () => {
    cy.visit('https://127.0.0.1:8000/register')
    cy.get('#register_firstname').type("Mathieu")
    cy.get('#register_lastname').type("Mithridate")
    cy.get('#register_email').type("mathieu.mith3@laposte.net")
    cy.get('#register_password').type("Azertyuio1234")
    cy.get('[type="submit"]').click()
    cy.wait(2000)
    cy.get('p.alert').should('contain', "Le compte a ete ajoute")
  })
  it('doublon', () => {
    cy.visit('https://127.0.0.1:8000/register')
    cy.get('#register_firstname').type("Mathieu")
    cy.get('#register_lastname').type("Mithridate")
    cy.get('#register_email').type("mathieu.mith3@laposte.net")
    cy.get('#register_password').type("Azertyuio1234")
    cy.get('[type="submit"]').click()
    cy.wait(2000)
    cy.get('p.alert').should('contain' ,"Le compte existe deja")
  })
})