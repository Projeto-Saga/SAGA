package br.com.saga;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

public interface CursandoRepository extends JpaRepository<Cursando, Long>
{
    @Query("SELECT c FROM Cursando c WHERE c.regx_user = :regx_user")
    List<Cursando> findByRegxUser(@Param("regx_user") Long regx_user);
}
