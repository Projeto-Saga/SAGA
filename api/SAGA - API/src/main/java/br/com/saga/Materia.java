package br.com.saga;

import org.springframework.hateoas.RepresentationModel;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;

@Entity
@Table(name = "materia")
public class Materia extends RepresentationModel<Materia>
{
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long iden_matr;
    private String nome_matr;
    private Integer chor_matr;
    private String abrv_matr;
    private Integer ccpv_matr;
    private Integer dias_matr;
    private String hora_matr;

    public Materia()
    {

    }

	public Long getIden_matr() {
		return iden_matr;
	}

	public void setIden_matr(Long iden_matr) {
		this.iden_matr = iden_matr;
	}

	public String getNome_matr() {
		return nome_matr;
	}

	public void setNome_matr(String nome_matr) {
		this.nome_matr = nome_matr;
	}

	public Integer getChor_matr() {
		return chor_matr;
	}

	public void setChor_matr(Integer chor_matr) {
		this.chor_matr = chor_matr;
	}

	public String getAbrv_matr() {
		return abrv_matr;
	}

	public void setAbrv_matr(String abrv_matr) {
		this.abrv_matr = abrv_matr;
	}

	public Integer getCcpv_matr() {
		return ccpv_matr;
	}

	public void setCcpv_matr(Integer ccpv_matr) {
		this.ccpv_matr = ccpv_matr;
	}

	public Integer getDias_matr() {
		return dias_matr;
	}

	public void setDias_matr(Integer dias_matr) {
		this.dias_matr = dias_matr;
	}

	public String getHora_matr() {
		return hora_matr;
	}

	public void setHora_matr(String hora_matr) {
		this.hora_matr = hora_matr;
	}
}