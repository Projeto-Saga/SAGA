package br.com.saga;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import io.swagger.v3.oas.annotations.Operation;

@RestController
@RequestMapping(value = "/aux/cursando")
public class CursandoRest
{
	@Autowired
	private CursandoRepository rep;
	
	@Operation(summary = "Consulta",
              description = "Retorna as matérias cursadas por determinado aluno.",
              tags = "Gestão de Trajetória")
	@GetMapping(value = "/find_one={iden}")
	public List<Cursando> find_one(@PathVariable("iden") Long iden)
	{
	    List<Cursando> crsn = rep.findByRegxUser(iden);

	    if (!crsn.isEmpty())
	    {
	        return crsn;
	    }
	    else
	    {
	        throw new ResourceNotFoundException("Aluno não encontrado com RA: " + iden);
	    }
	}
	
	@Operation(summary = "Rematrícula",
			   description = "Inscreve determinado aluno nas seguintes matérias.",
			   tags = "Gestão de Trajetória")
	@PostMapping(value = "/insert")
	public Cursando insert(@RequestBody Cursando crsn)
	{
		return rep.save(crsn);
	}
}
