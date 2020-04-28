function DataBonita(now, time)
{
    /* Função é responsável por pegar a diferença de horário entre um post
    e a hora atual e, ao invés de mostrar um tempo, mostrar uma mensagem
    que faça sentido para o usuário */
    
    var date = new Date(time || "");
    var diff = (((new Date(now)).getTime() - date.getTime()) / 1000);
    var day_diff = Math.floor(diff / 86400);
   
    if (isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
      return;
   
    return day_diff == 0 && 
    (
        diff < 60 && "neste instante" ||
        diff < 120 && "1 minuto atrás" ||
        diff < 3600 && Math.floor( diff / 60 ) +
          " minutos atrás" ||
        diff < 7200 && "1 hora atrás" ||
        diff < 86400 && Math.floor( diff / 3600 ) +
          " horas atrás"
    ) ||
      day_diff == 1 && "Ontem" ||
      day_diff < 7 && day_diff + " dias atrás" ||
      day_diff < 31 && Math.ceil( day_diff / 7 ) +
        " semanas atrás";
  }