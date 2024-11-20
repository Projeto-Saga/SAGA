package br.com.saga;

import java.util.List;
import java.util.Optional;

import static org.springframework.hateoas.server.mvc.WebMvcLinkBuilder.linkTo;
import static org.springframework.hateoas.server.mvc.WebMvcLinkBuilder.methodOn;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import io.swagger.v3.oas.annotations.Operation;

@RestController
@RequestMapping(value = "/aux/materia")
public class MateriaRest
{
	@Autowired
	private MateriaRepository rep;
	
	@Operation(summary = "Listagem",
			   description = "Retorna dados de todas as matérias da base.",
			   tags = "Gestão de Conteúdo")
	@GetMapping(value = "/find_all")
	public List<Materia> find_all()
	{
		List<Materia> list = rep.findAll();
		
		for (Materia matr : list)
		{
			matr.add(linkTo(methodOn(MateriaRest.class).update(matr.getIden_matr(), new Materia())).withRel("Alterar Esta Matéria"));
		}
		
		return list;
	}
	
	@Operation(summary = "Inclusão",
			   description = "Inclui uma nova matéria no escopo da base.",
			   tags = "Gestão de Conteúdo")
	@PostMapping(value = "/insert")
	public Materia insert(@RequestBody Materia matr)
	{
		return rep.save(matr);
	}
	
	@Operation(summary = "Alteração",
			   description = "Reconfigura uma matéria do escopo da base.",
			   tags = "Gestão de Conteúdo")
	@PutMapping(value = "/update={iden}")
	public Materia update(@PathVariable("iden") Long iden, @RequestBody Materia matr)
	{
	    Optional<Materia> optn = rep.findById(iden);
	    
	    if (optn.isPresent())
	    {
	        Materia updt = optn.get();

	        if (matr.getNome_matr() != null) updt.setNome_matr(matr.getNome_matr());
	        if (matr.getChor_matr() != null) updt.setChor_matr(matr.getChor_matr());
	        if (matr.getAbrv_matr() != null) updt.setAbrv_matr(matr.getAbrv_matr());
	        if (matr.getCcpv_matr() != null) updt.setCcpv_matr(matr.getCcpv_matr());
	        if (matr.getDias_matr() != null) updt.setDias_matr(matr.getDias_matr());
	        if (matr.getHora_matr() != null) updt.setHora_matr(matr.getHora_matr());

	        rep.save(updt);

	        return updt;
	    }
	    else
	    {
	        throw new ResourceNotFoundException("Matéria não encontrada com ID: " + iden);
	    }
	}
}