package br.com.saga;

import org.springframework.hateoas.RepresentationModel;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;

@Entity
@Table(name = "cursando")
public class Cursando extends RepresentationModel<Cursando>
{
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long iden_crsn;
    private Integer regx_user;
    private Integer iden_matr;
    private double ntp1_crsn;
    private double ntp2_crsn;
    private double ntp3_crsn;
    private double nttt_crsn;
    private Integer falt_crsn;
    private String cicl_alun;
    private String _ano_crsn;
    private String _sem_crsn;
    private String situ_crsn;

    public Cursando()
    {

    }

	public Long getIden_crsn() {
		return iden_crsn;
	}

	public void setIden_crsn(Long iden_crsn) {
		this.iden_crsn = iden_crsn;
	}

	public Integer getRegx_user() {
		return regx_user;
	}

	public void setRegx_user(Integer regx_user) {
		this.regx_user = regx_user;
	}

	public Integer getIden_matr() {
		return iden_matr;
	}

	public void setIden_matr(Integer iden_matr) {
		this.iden_matr = iden_matr;
	}

	public double getNtp1_crsn() {
		return ntp1_crsn;
	}

	public void setNtp1_crsn(double ntp1_crsn) {
		this.ntp1_crsn = ntp1_crsn;
	}

	public double getNtp2_crsn() {
		return ntp2_crsn;
	}

	public void setNtp2_crsn(double ntp2_crsn) {
		this.ntp2_crsn = ntp2_crsn;
	}

	public double getNtp3_crsn() {
		return ntp3_crsn;
	}

	public void setNtp3_crsn(double ntp3_crsn) {
		this.ntp3_crsn = ntp3_crsn;
	}

	public double getNttt_crsn() {
		return nttt_crsn;
	}

	public void setNttt_crsn(double nttt_crsn) {
		this.nttt_crsn = nttt_crsn;
	}

	public Integer getFalt_crsn() {
		return falt_crsn;
	}

	public void setFalt_crsn(Integer falt_crsn) {
		this.falt_crsn = falt_crsn;
	}

	public String getCicl_alun() {
		return cicl_alun;
	}

	public void setCicl_alun(String cicl_alun) {
		this.cicl_alun = cicl_alun;
	}

	public String get_ano_crsn() {
		return _ano_crsn;
	}

	public void set_ano_crsn(String _ano_crsn) {
		this._ano_crsn = _ano_crsn;
	}

	public String get_sem_crsn() {
		return _sem_crsn;
	}

	public void set_sem_crsn(String _sem_crsn) {
		this._sem_crsn = _sem_crsn;
	}

	public String getSitu_crsn() {
		return situ_crsn;
	}

	public void setSitu_crsn(String situ_crsn) {
		this.situ_crsn = situ_crsn;
	}
}