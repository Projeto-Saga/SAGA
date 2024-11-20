package br.com.saga;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import io.swagger.v3.oas.models.OpenAPI;
import io.swagger.v3.oas.models.info.Info;
import io.swagger.v3.oas.models.info.License;

@Configuration
public class SwaggerConfiguration
{
	@Bean
	OpenAPI customAPI()
	{
		return new OpenAPI().info(new Info()
				.title("SAGA")
				.description("Sistema Acadêmico de Gestão Aprimorado")
				.version("1.0.0"));
	}

}
